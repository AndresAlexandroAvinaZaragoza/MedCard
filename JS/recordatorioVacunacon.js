/* recordatorioVacunacon.js
   - IndexedDB storage
   - Service Worker registration + notifications
   - Avisar X minutos antes (configurable por recordatorio)
   - Crear/editar/eliminar, snooze, export/import
*/

const DB_NAME = 'salud_reminders_db_v3';
const STORE = 'reminders';

// ---------- IndexedDB helpers ----------
function openDB() {
  return new Promise((resolve, reject) => {
    const rq = indexedDB.open(DB_NAME, 1);
    rq.onupgradeneeded = () => {
      const db = rq.result;
      if (!db.objectStoreNames.contains(STORE)) {
        const os = db.createObjectStore(STORE, { keyPath: 'id' });
        os.createIndex('when', 'when', { unique: false });
      }
    };
    rq.onsuccess = () => resolve(rq.result);
    rq.onerror = () => reject(rq.error);
  });
}

async function idbGetAll() {
  const db = await openDB();
  return new Promise((res, rej) => {
    const tx = db.transaction(STORE,'readonly');
    const req = tx.objectStore(STORE).getAll();
    req.onsuccess = () => res(req.result || []);
    req.onerror = () => rej(req.error);
  });
}

async function idbPut(item) {
  const db = await openDB();
  return new Promise((res, rej) => {
    const tx = db.transaction(STORE,'readwrite');
    const req = tx.objectStore(STORE).put(item);
    req.onsuccess = () => res(req.result);
    req.onerror = () => rej(tx.error || req.error);
  });
}

async function idbDelete(id) {
  const db = await openDB();
  return new Promise((res, rej) => {
    const tx = db.transaction(STORE,'readwrite');
    const req = tx.objectStore(STORE).delete(id);
    req.onsuccess = () => res();
    req.onerror = () => rej(tx.error || req.error);
  });
}

// ---------- DOM refs ----------
const btnAgregar = document.getElementById('btnAgregarRecordatorio');
const modal = document.getElementById('modalRecordatorio');
const cerrarModalBtn = document.getElementById('cerrarModal');
const cerrarModalBtn2 = document.getElementById('cerrarModalBtn2');
const form = document.getElementById('formRecordatorio');
const lista = document.getElementById('listaRecordatorios');

const filtroVacuna = document.getElementById('vacuna');
const filtroEstado = document.getElementById('estado');

const btnPedirPermiso = document.getElementById('btnPedirPermiso');
const btnExportar = document.getElementById('btnExportar');
const btnImportar = document.getElementById('btnImportar');
const fileImport = document.getElementById('fileImport');

const toast = document.getElementById('toast');
const modalTitle = document.getElementById('modalTitle');

let editingId = null;

// ---------- UI interactions ----------
btnAgregar.addEventListener('click', () => {
  editingId = null;
  modalTitle.textContent = 'Nuevo Recordatorio';
  form.reset();
  modal.style.display = 'flex';
});
cerrarModalBtn.addEventListener('click', () => modal.style.display = 'none');
cerrarModalBtn2.addEventListener('click', () => modal.style.display = 'none');
window.addEventListener('click', (e) => { if (e.target === modal) modal.style.display = 'none'; });

// ---------- Service Worker registration ----------
async function registerSW() {
  if ('serviceWorker' in navigator) {
    try {
      // Ajusta la ruta si no está en raíz:
      await navigator.serviceWorker.register('/service-worker.js');
      console.log('Service Worker registrado');
    } catch (e) {
      console.warn('Error registrando SW:', e);
    }
  }
}

// ---------- Notificaciones ----------
btnPedirPermiso.addEventListener('click', async () => {
  if (!('Notification' in window)) return alert('Notificaciones no soportadas en este navegador');
  const p = await Notification.requestPermission();
  alert('Permiso de notificación: ' + p);
});

async function showNotif(title, body) {
  const options = { body, tag: 'reminder', renotify: true };
  try {
    const reg = await navigator.serviceWorker.getRegistration();
    if (reg && reg.showNotification) {
      reg.showNotification(title, options);
      return;
    }
  } catch (e) { /* ignore */ }
  if (Notification.permission === 'granted') new Notification(title, options);
}

// ---------- Rendering ----------
function escapeHtml(s){ return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

async function mostrarRecordatorios() {
  let items = await idbGetAll();
  // filtros
  const vacunaFiltro = filtroVacuna.value;
  const estadoFiltro = filtroEstado.value;

  if (vacunaFiltro !== 'Todas las Vacunas') items = items.filter(i => i.vacuna === vacunaFiltro);
  if (estadoFiltro !== 'Todos los Estados') items = items.filter(i => i.estado === estadoFiltro);

  items.sort((a,b)=> new Date(a.when) - new Date(b.when));

  lista.innerHTML = '';
  if (items.length === 0) {
    lista.innerHTML = '<p style="text-align:center; color:#555; margin-top:2rem;">No hay recordatorios que mostrar.</p>';
    return;
  }

  for (const rec of items) {
    const card = document.createElement('div');
    card.className = 'card-item';
    const fechaStr = new Date(rec.when).toLocaleString();

    // Mostrar si está cerca (según notifyBefore) en la UI
    const now = new Date();
    const whenDate = new Date(rec.when);
    const msBefore = (whenDate.getTime() - now.getTime());
    const isDueSoon = (msBefore <= (rec.notifyBeforeMinutes || 0) * 60000) && msBefore > -60000;

    card.innerHTML = `
      <div style="flex:1;">
        <div class="meta"><strong>Vacuna:</strong> <span class="editable" contenteditable="true" data-field="vacuna" data-id="${rec.id}">${escapeHtml(rec.vacuna)}</span></div>
        <div class="meta"><strong>Fecha:</strong> <input class="editable-date" data-field="when" data-id="${rec.id}" type="datetime-local" value="${toInputDatetimeLocal(rec.when)}"></div>
        <div class="meta"><strong>Estado:</strong> 
          <select class="editable-select" data-field="estado" data-id="${rec.id}">
            <option ${rec.estado==='Pendiente'?'selected':''}>Pendiente</option>
            <option ${rec.estado==='Completado'?'selected':''}>Completado</option>
            <option ${rec.estado==='Retrasado'?'selected':''}>Retrasado</option>
          </select>
        </div>
        <div class="meta"><strong>Avisar antes:</strong> ${rec.notifyBeforeMinutes || 0} min</div>
        ${isDueSoon ? '<div style="color:#b33; font-weight:700;">PRÓXIMO</div>' : ''}
      </div>

      <div class="actions" style="display:flex; flex-direction:column; gap:8px; margin-left:12px; align-items:flex-end;">
        <div style="display:flex; gap:6px;">
          <select class="snooze-select" data-id="${rec.id}">
            <option value="0">Snooze</option>
            <option value="1">1 min</option>
            <option value="5">5 min</option>
            <option value="10">10 min</option>
            <option value="30">30 min</option>
          </select>
          <button data-id="${rec.id}" data-action="applySnooze">OK</button>
        </div>
        <div style="display:flex; gap:6px;">
          <button data-id="${rec.id}" data-action="saveEdit" style="padding:6px 8px; border-radius:6px; cursor:pointer;">Guardar</button>
          <button data-id="${rec.id}" data-action="editModal" style="padding:6px 8px; border-radius:6px; cursor:pointer;">Abrir</button>
          <button data-id="${rec.id}" data-action="delete" style="background:#e14c4c; color:#fff; border:none; padding:6px 8px; border-radius:6px; cursor:pointer;">Eliminar</button>
        </div>
      </div>
    `;

    lista.appendChild(card);
  }
}

function toInputDatetimeLocal(iso) {
  const d = new Date(iso);
  const pad = n => String(n).padStart(2,'0');
  const YYYY = d.getFullYear();
  const MM = pad(d.getMonth()+1);
  const DD = pad(d.getDate());
  const hh = pad(d.getHours());
  const mm = pad(d.getMinutes());
  return `${YYYY}-${MM}-${DD}T${hh}:${mm}`;
}

// ---------- Form submit (create/edit) ----------
form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const vacuna = document.getElementById('vacunaInput').value;
  const fecha = document.getElementById('fechaInput').value;
  const avisar = Number(document.getElementById('avisarInput').value || 0);
  const estado = document.getElementById('estadoInput').value;
  if (!vacuna || !fecha || !estado) return alert('Completa todos los campos');

  if (editingId) {
    const items = await idbGetAll();
    const it = items.find(x=> x.id === editingId);
    if (!it) return alert('Item no encontrado');
    it.vacuna = vacuna;
    it.when = new Date(fecha).toISOString();
    it.notifyBeforeMinutes = avisar;
    it.estado = estado;
    it.fired = false;
    it.notifiedBefore = false; // reset notification-before flag
    await idbPut(it);
  } else {
    const item = {
      id: String(Date.now()) + Math.random().toString(36).slice(2,8),
      vacuna,
      when: new Date(fecha).toISOString(),
      notifyBeforeMinutes: avisar,
      estado,
      fired: false,
      notifiedBefore: false // indica si ya se le envió la notificación "antes"
    };
    await idbPut(item);
  }

  form.reset();
  modal.style.display = 'none';
  editingId = null;
  await mostrarRecordatorios();
});

// ---------- Delegación: lista (save, snooze, delete, open modal edit) ----------
lista.addEventListener('click', async (ev) => {
  const btn = ev.target.closest('button');
  if (!btn) return;
  const id = btn.dataset.id;
  const action = btn.dataset.action;

  if (action === 'delete') {
    if (!confirm('Eliminar recordatorio?')) return;
    await idbDelete(id);
    await mostrarRecordatorios();
    return;
  }

  if (action === 'saveEdit') {
    const root = btn.closest('.card-item');
    const vacunaEl = root.querySelector('[data-field="vacuna"]');
    const whenEl = root.querySelector('input[data-field="when"]');
    const estadoEl = root.querySelector('select.editable-select');

    const vacuna = vacunaEl.textContent.trim();
    const when = whenEl.value;
    const estado = estadoEl.value;

    if (!vacuna || !when || !estado) return alert('Completa todos los campos antes de guardar');

    const items = await idbGetAll();
    const it = items.find(x=> x.id === id);
    if (!it) return alert('Item no encontrado');
    it.vacuna = vacuna;
    it.when = new Date(when).toISOString();
    it.estado = estado;
    it.fired = false;
    it.notifiedBefore = false;
    await idbPut(it);
    await mostrarRecordatorios();
    return;
  }

  if (action === 'applySnooze') {
    const root = btn.closest('.card-item');
    const sel = root.querySelector('.snooze-select');
    const minutes = Number(sel.value || 0);
    if (!minutes) return;
    const items = await idbGetAll();
    const it = items.find(x=> x.id === id);
    if (!it) return;
    it.when = new Date(new Date(it.when).getTime() + minutes*60000).toISOString();
    it.fired = false;
    it.notifiedBefore = false;
    await idbPut(it);
    await mostrarRecordatorios();
    return;
  }

  if (action === 'editModal') {
    // abrir modal y rellenar con valores existentes
    const items = await idbGetAll();
    const it = items.find(x=> x.id === id);
    if (!it) return alert('Item no encontrado');
    editingId = id;
    modalTitle.textContent = 'Editar Recordatorio';
    document.getElementById('vacunaInput').value = it.vacuna;
    document.getElementById('fechaInput').value = toInputDatetimeLocal(it.when);
    document.getElementById('avisarInput').value = it.notifyBeforeMinutes || 0;
    document.getElementById('estadoInput').value = it.estado;
    modal.style.display = 'flex';
    return;
  }
});

// ---------- Export / Import ----------
btnExportar.addEventListener('click', async () => {
  const all = await idbGetAll();
  const blob = new Blob([JSON.stringify(all, null, 2)], {type:'application/json'});
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a'); a.href = url; a.download = 'recordatorios.json'; a.click();
  URL.revokeObjectURL(url);
});

btnImportar.addEventListener('click', ()=> fileImport.click());
fileImport.addEventListener('change', async (ev) => {
  const f = ev.target.files[0];
  if (!f) return;
  const txt = await f.text();
  try {
    const arr = JSON.parse(txt);
    if (!Array.isArray(arr)) throw 'Formato inválido';
    for (const item of arr) {
      if (!item.id) item.id = String(Date.now()) + Math.random().toString(36).slice(2,8);
      item.fired = item.fired || false;
      item.notifiedBefore = item.notifiedBefore || false;
      if (!item.when && item.fecha) item.when = new Date(item.fecha).toISOString();
      await idbPut(item);
    }
    await mostrarRecordatorios();
    alert('Importado con éxito');
  } catch (e) {
    alert('Error importando: ' + e);
  }
});

// ---------- Check and fire: notificar "antes" y notificar al llegar ----------
async function checkAndFire() {
  const ahora = new Date();
  const items = await idbGetAll();

  for (const it of items) {
    const when = new Date(it.when);
    const msBefore = when.getTime() - ahora.getTime();

    // 1) Notificación "antes" (si no se ha notificado antes)
    const notifyBeforeMs = (it.notifyBeforeMinutes || 0) * 60000;
    if (!it.notifiedBefore && notifyBeforeMs > 0 && msBefore <= notifyBeforeMs && msBefore > -60000) {
      // envia notificación previa
      await showNotif('⏰ Próxima cita', `${it.vacuna} en ${Math.max(0, Math.round(msBefore/60000))} min — ${new Date(it.when).toLocaleString()}`);
      it.notifiedBefore = true;
      await idbPut(it);
      // toast
      toast.textContent = `⏰ Próxima cita: ${it.vacuna} — ${new Date(it.when).toLocaleString()}`;
      toast.style.display = 'block';
      setTimeout(()=> toast.style.display = 'none', 7000);
    }

    // 2) Notificación al llegar (si no disparado)
    if (!it.fired && msBefore <= 0) {
      it.fired = true;
      await idbPut(it);
      await showNotif('⏰ Es hora de tu cita', `${it.vacuna} — ${new Date(it.when).toLocaleString()}`);
      toast.textContent = `⏰ Es hora: ${it.vacuna} — ${new Date(it.when).toLocaleString()}`;
      toast.style.display = 'block';
      setTimeout(()=> toast.style.display = 'none', 7000);
      // opcional: marcar estado retrasado si llegó y sigue pendiente
      if (it.estado === 'Pendiente') {
        it.estado = 'Retrasado';
        await idbPut(it);
      }
    }
  }

  await mostrarRecordatorios();
}

// revisa cada 10s
setInterval(checkAndFire, 10000);
document.addEventListener('visibilitychange', ()=> { if (!document.hidden) checkAndFire(); });
window.addEventListener('focus', checkAndFire);

// filtros re-render
filtroVacuna.addEventListener('change', mostrarRecordatorios);
filtroEstado.addEventListener('change', mostrarRecordatorios);

// ---------- Init ----------
(async function init(){
  await registerSW();
  await mostrarRecordatorios();
  checkAndFire();
})();
