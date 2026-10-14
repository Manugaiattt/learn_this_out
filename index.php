<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prueba — Mercado Informático</title>
  <link class="replaced" rel="manifest" href="manifest.json">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.6.0/mammoth.browser.min.js"></script>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg: #0f0f0f;
      --card: #181818;
      --card2: #1e1e1e;
      --border: #262626;
      --border2: #333;
      --text: #e2e2e2;
      --muted: #777;
      --faint: #444;
      --accent: #a78bfa;
      --accent-dim: #1d1530;
      --success: #4ade80;
      --success-dim: #0c1f13;
      --error: #f87171;
      --error-dim: #240e0e;
      --warn: #fbbf24;
      --warn-dim: #1e1600;
      --radius: 10px;
    }

    html, body {
      height: 100%;
      background: var(--bg);
      color: var(--text);
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
      font-size: 15px;
      line-height: 1.6;
    }

    .app {
      display: flex;
      height: calc(100vh - 60px);
      overflow: hidden;
    }

    .sidebar {
      width: 220px;
      min-width: 220px;
      background: var(--card);
      border-right: 0.5px solid var(--border);
      display: flex;
      flex-direction: column;
      padding: 1.25rem 0;
      overflow-y: auto;
    }

    .main {
      flex: 1;
      overflow-y: auto;
      padding: 2rem 2.5rem;
    }

    .sidebar-logo {
      padding: 0 1.25rem 1.25rem;
      border-bottom: 0.5px solid var(--border);
      margin-bottom: 0.75rem;
    }

    .sidebar-logo h2 {
      font-size: 14px;
      font-weight: 600;
      color: var(--text);
      letter-spacing: -0.02em;
    }

    .sidebar-logo p {
      font-size: 11px;
      color: var(--muted);
      margin-top: 2px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 9px;
      width: 100%;
      padding: 0.55rem 1.25rem;
      background: none;
      border: none;
      text-align: left;
      font-size: 13px;
      color: var(--muted);
      cursor: pointer;
      transition: color 0.12s, background 0.12s;
    }

    .nav-item:hover {
      color: var(--text);
      background: rgba(255,255,255,0.04);
    }

    .nav-item.active {
      color: var(--text);
      background: rgba(167,139,250,0.1);
    }

    .nav-item .icon {
      width: 18px;
      flex-shrink: 0;
      text-align: center;
      font-size: 15px;
    }

    .nav-section {
      padding: 0.75rem 1.25rem 0.3rem;
      font-size: 10px;
      letter-spacing: 0.1em;
      color: var(--faint);
      text-transform: uppercase;
    }

    .sidebar-stats {
      margin-top: auto;
      padding: 1rem 1.25rem;
      border-top: 0.5px solid var(--border);
    }

    .sidebar-stats p {
      font-size: 11px;
      color: var(--muted);
    }

    .sidebar-stats strong {
      color: var(--text);
    }

    button {
      border: none;
      cursor: pointer;
      font-family: inherit;
      transition: all 0.12s;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 0.45rem 1rem;
      border-radius: 7px;
      font-size: 13px;
      font-weight: 400;
    }

    .btn-primary {
      background: var(--accent);
      color: #0a0a0a;
      font-weight: 500;
    }

    .btn-primary:hover {
      background: #c4b5fd;
    }

    .btn-primary:disabled {
      opacity: 0.35;
      cursor: not-allowed;
    }

    .btn-ghost {
      background: transparent;
      color: var(--muted);
      border: 0.5px solid var(--border2);
    }

    .btn-ghost:hover {
      color: var(--text);
      border-color: var(--faint);
      background: rgba(255,255,255,0.03);
    }

    .btn-danger {
      background: transparent;
      color: var(--error);
      border: 0.5px solid #3a1a1a;
    }

    .btn-danger:hover {
      background: var(--error-dim);
    }

    .btn-sm {
      font-size: 12px;
      padding: 0.3rem 0.7rem;
    }

    .quiz-header {
      margin-bottom: 1.5rem;
    }

    .quiz-header h1 {
      font-size: 18px;
      font-weight: 500;
      margin-bottom: 0.2rem;
    }

    .quiz-header p {
      font-size: 13px;
      color: var(--muted);
    }

    .progress-wrap {
      background: #1e1e1e;
      border-radius: 99px;
      height: 3px;
      margin-bottom: 1.25rem;
    }

    .progress-fill {
      height: 3px;
      border-radius: 99px;
      background: var(--accent);
      transition: width 0.4s ease;
    }

    .q-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }

    .q-num {
      font-size: 12px;
      color: var(--muted);
    }

    .dots {
      display: flex;
      gap: 4px;
      flex-wrap: wrap;
      max-width: 300px;
      justify-content: flex-end;
    }

    .dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: #2a2a2a;
      transition: background 0.2s;
    }

    .dot.done { background: #444; }
    .dot.cur { background: var(--accent); }
    .dot.ok { background: var(--success); }
    .dot.bad { background: var(--error); }
    .dot.half { background: var(--warn); }

    .q-card {
      background: var(--card);
      border: 0.5px solid var(--border);
      border-radius: var(--radius);
      padding: 1.5rem;
      margin-bottom: 1rem;
    }

    .q-source {
      font-size: 11px;
      color: var(--accent);
      font-weight: 500;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      margin-bottom: 0.6rem;
    }

    .q-text {
      font-size: 16px;
      line-height: 1.65;
    }

    textarea {
      width: 100%;
      background: #131313;
      border: 0.5px solid var(--border);
      border-radius: 8px;
      color: var(--text);
      font-size: 14px;
      font-family: inherit;
      line-height: 1.65;
      padding: 0.75rem 1rem;
      resize: vertical;
      min-height: 110px;
      margin-top: 1.25rem;
      transition: border-color 0.15s;
    }

    textarea:focus {
      outline: none;
      border-color: var(--border2);
    }

    textarea::placeholder {
      color: #3a3a3a;
    }

    .actions {
      display: flex;
      gap: 0.6rem;
      margin-top: 0.85rem;
      align-items: center;
    }

    .btn-skip-txt {
      background: none;
      border: none;
      color: var(--faint);
      font-size: 12px;
      font-family: inherit;
      cursor: pointer;
      margin-left: auto;
    }

    .btn-skip-txt:hover {
      color: var(--muted);
    }

    .feedback {
      border-radius: 8px;
      padding: 1rem 1.1rem;
      margin-top: 0.85rem;
      font-size: 13.5px;
      line-height: 1.6;
    }

    .feedback.loading {
      background: #161616;
      color: var(--muted);
      border: 0.5px solid var(--border);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .feedback.ok {
      background: var(--success-dim);
      border: 0.5px solid #1a3a22;
      color: var(--success);
    }

    .feedback.bad {
      background: var(--error-dim);
      border: 0.5px solid #3a1a1a;
      color: var(--error);
    }

    .feedback.half {
      background: var(--warn-dim);
      border: 0.5px solid #332500;
      color: var(--warn);
    }

    .fb-label {
      font-weight: 500;
      display: block;
      margin-bottom: 0.3rem;
    }

    .fb-detail {
      color: #999;
      font-style: italic;
      margin-top: 0.4rem;
      font-size: 13px;
    }

    .spinner {
      width: 15px;
      height: 15px;
      border: 2px solid #2a2a2a;
      border-top-color: var(--accent);
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
      flex-shrink: 0;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .timer-box {
      display: inline-flex;
      align-items: center;
      gap: 0.55rem;
      background: #141414;
      border: 1px solid #1e1e1e;
      border-radius: 12px;
      padding: 0.7rem 1rem;
      margin-bottom: 1.25rem;
      transition: all 0.25s ease;
    }

    .timer-box .timer-label {
      font-size: 12px;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #5f5f5f;
      font-weight: 600;
    }

    .timer-box .timer-display {
      font-size: 1.8rem;
      font-weight: 700;
      line-height: 1;
      color: #5a5a5a;
      font-variant-numeric: tabular-nums;
      letter-spacing: 0.04em;
    }

    .timer-box.active {
      background: #1a1a1a;
      border-color: #2a2a2a;
    }

    .timer-box.active .timer-label {
      color: #8a8a8a;
    }

    .timer-box.active .timer-display {
      color: #cfcfcf;
    }

    .timer-box.low-time {
      border-color: #3a1a1a;
      background: var(--error-dim);
    }

    .timer-box.low-time .timer-label,
    .timer-box.low-time .timer-display {
      color: var(--error);
    }

    .app-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background-color: #1a1a1a;
      color: #fff;
      height: 60px;
      border-bottom: 1px solid var(--border);
    }

    .account-container {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .user-badge {
      background-color: #a78bfa;
      color: #0f0f0f;
      padding: 6px 12px;
      border-radius: 20px;
      font-weight: bold;
      cursor: pointer;
    }

    .btn-secondary {
      background-color: #333;
      color: #fff;
      border: 1px solid #555;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
    }

    .btn-secondary:hover {
      background-color: #444;
    }

    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }

    .modal-box {
      background: #181818;
      border: 1px solid var(--border);
      padding: 25px;
      border-radius: 12px;
      width: 90%;
      max-width: 380px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.5);
      color: var(--text);
    }

    .modal-box h2 {
      margin-bottom: 15px;
      font-size: 18px;
    }

    .modal-box input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid var(--border2);
      background: #111;
      color: #fff;
      border-radius: 6px;
    }

    .close-btn {
      float: right;
      font-size: 20px;
      cursor: pointer;
      color: var(--muted);
    }
    
    .close-btn:hover { color: #fff; }

    /* ── Zona de subida de Word ─────────────────────────────────────────── */
    .upload-zone {
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 0.65rem;
      padding: 2.25rem 1.5rem;
      margin-bottom: 1.5rem;
      border: 1.5px dashed var(--border2);
      border-radius: 16px;
      background: var(--card);
      cursor: pointer;
      transition: border-color 0.15s ease, background 0.15s ease, transform 0.12s ease;
    }

    .upload-zone:hover {
      border-color: #4a4360;
      background: #1a1723;
    }

    .upload-zone.drag {
      border-color: var(--accent);
      background: var(--accent-dim);
      transform: scale(1.01);
    }

    .upload-zone .uz-icon {
      width: 46px;
      height: 46px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--accent-dim);
      color: var(--accent);
      transition: background 0.15s ease, transform 0.15s ease;
    }

    .upload-zone:hover .uz-icon,
    .upload-zone.drag .uz-icon {
      transform: translateY(-2px);
    }

    .upload-zone .uz-icon svg {
      width: 22px;
      height: 22px;
    }

    .upload-zone h3 {
      font-size: 14.5px;
      font-weight: 500;
      color: var(--text);
    }

    .upload-zone p {
      font-size: 12.5px;
      color: var(--muted);
      max-width: 320px;
    }

    .uz-browse {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-top: 0.35rem;
      padding: 0.4rem 0.9rem;
      border-radius: 7px;
      background: var(--accent);
      color: #0a0a0a;
      font-size: 12.5px;
      font-weight: 500;
      pointer-events: none;
    }

    .uz-format {
      display: inline-block;
      margin-top: 0.15rem;
      font-size: 10.5px;
      letter-spacing: 0.04em;
      color: var(--faint);
    }

    /* ── Estado de la subida ────────────────────────────────────────────── */
    .upload-status {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 0.85rem 1rem;
      margin-bottom: 1.5rem;
      border-radius: var(--radius);
      font-size: 13px;
      border: 0.5px solid var(--border);
      background: var(--card);
      color: var(--muted);
    }

    .upload-status.loading {
      color: var(--text);
    }

    .upload-status.success {
      border-color: #1a3a22;
      background: var(--success-dim);
      color: var(--success);
    }

    .upload-status.error {
      border-color: #3a1a1a;
      background: var(--error-dim);
      color: var(--error);
    }

    .upload-status .us-icon {
      flex-shrink: 0;
      display: flex;
    }

    .upload-status .us-icon svg {
      width: 16px;
      height: 16px;
    }
  </style>
</head>
<body>

  <!-- Navbar / Encabezado -->
  <header class="app-header">
      <h1>Mercado Informático</h1>
      <div id="account-widget" class="account-container"></div>
  </header>

  <!-- Modal de Perfil/Cuenta -->
  <div id="profile-modal" class="modal-overlay" style="display: none;">
      <div class="modal-box">
          <span class="close-btn" onclick="closeProfileModal()">&times;</span>
          <h2>Mi Cuenta</h2>
          <p style="margin-bottom: 8px;"><strong>Usuario:</strong> <span id="profile-username"></span></p>
          <p style="margin-bottom: 20px;"><strong>Email:</strong> <span id="profile-email"></span></p>
          <button id="logout-btn" class="btn-secondary" style="width: 100%;" onclick="logoutUser()">Cerrar Sesión</button>
      </div>
  </div>

  <!-- Modal de Autenticación -->
  <div id="authModal" class="modal-overlay" style="display: none;">
    <div class="modal-box">
      <!-- Formulario de Login -->
      <div id="loginForm">
        <h2>Iniciar Sesión</h2>
        <input type="text" id="loginUser" placeholder="Usuario">
        <input type="password" id="loginPass" placeholder="Contraseña">
        <button onclick="ejecutarLogin()" style="width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 6px; font-weight: bold; margin-top: 10px; cursor: pointer;">Entrar</button>
        <p style="margin-top: 15px; text-align: center; font-size: 14px;">
          ¿No tienes cuenta? <a href="#" onclick="toggleAuthForms(false)" style="color: var(--accent);">Regístrate aquí</a>
        </p>
      </div>

      <!-- Formulario de Registro -->
      <div id="registerForm" style="display: none;">
        <h2>Crear Cuenta</h2>
        <input type="text" id="regUser" placeholder="Usuario">
        <input type="email" id="regEmail" placeholder="Correo electrónico">
        <input type="password" id="regPass" placeholder="Contraseña">
        <button onclick="ejecutarRegistro()" style="width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 6px; font-weight: bold; margin-top: 10px; cursor: pointer;">Registrarse</button>
        <p style="margin-top: 15px; text-align: center; font-size: 14px;">
          ¿Ya tienes cuenta? <a href="#" onclick="toggleAuthForms(true)" style="color: var(--accent);">Inicia Sesión</a>
        </p>
      </div>

      <div id="authMessage" style="margin-top: 10px; color: var(--error); font-size: 14px; text-align: center;"></div>
    </div>
  </div>

  <div class="app">
    <nav class="sidebar">
      <div class="sidebar-logo">
        <h2>Prueba Escrita</h2>
        <p>Mercado informático</p>
      </div>
      <div class="nav-section">Menú</div>
      <button class="nav-item active" id="nav-quiz" onclick="showScreen('quiz')">
        <span class="icon">📝</span> Hacer prueba
      </button>
      <button class="nav-item" id="nav-manage" onclick="showScreen('manage')">
        <span class="icon">📚</span> Gestionar preguntas
      </button>
      <button class="nav-item" id="nav-difficulty" onclick="showScreen('difficulty')">
        <span class="icon">⚙️</span> Dificultad
      </button>
      <div class="sidebar-stats" id="sidebar-stats"></div>
    </nav>
    <main class="main" id="main"></main>
  </div>

<script>
  // Control y Estado de Sesión / UI
  function updateUIState() {
      const accountWidget = document.getElementById('account-widget');
      const token = localStorage.getItem('userToken');
      const username = localStorage.getItem('username');
      const email = localStorage.getItem('userEmail');

      if (token && username) {
          accountWidget.innerHTML = `
              <div class="user-badge" onclick="openProfileModal()">👤 ${username}</div>
              <button class="btn-secondary" onclick="logoutUser()">Salir</button>
          `;
          document.getElementById('profile-username').innerText = username;
          document.getElementById('profile-email').innerText = email || 'No especificado';
          document.getElementById('authModal').style.display = 'none';
      } else {
          accountWidget.innerHTML = `
              <button class="btn-secondary" onclick="openAuthModal()">Iniciar Sesión / Registrarse</button>
          `;
      }
  }

  function openAuthModal() { document.getElementById('authModal').style.display = 'flex'; }
  function openProfileModal() { document.getElementById('profile-modal').style.display = 'flex'; }
  function closeProfileModal() { document.getElementById('profile-modal').style.display = 'none'; }

  function logoutUser() {
      localStorage.removeItem('userToken');
      localStorage.removeItem('username');
      localStorage.removeItem('userEmail');
      localStorage.removeItem('usuario_pwa');
      closeProfileModal();
      updateUIState();
      alert('Has cerrado sesión.');
  }

  function toggleAuthForms(mostrarLogin) {
      document.getElementById('authMessage').innerText = '';
      document.getElementById('loginForm').style.display = mostrarLogin ? 'block' : 'none';
      document.getElementById('registerForm').style.display = mostrarLogin ? 'none' : 'block';
  }

  async function ejecutarLogin() {
  const user = document.getElementById('loginUser').value.trim();
  const pass = document.getElementById('loginPass').value.trim();
  const msg = document.getElementById('authMessage');

  if (!user || !pass) {
      msg.innerText = "Por favor, completa todos los campos.";
      return;
  }

  try {
      const res = await fetch('login.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ user, pass })
      });

      // Se procesa el JSON sin importar el código HTTP recibido
      const data = await res.json();

      if (res.ok && (data.success || data.status === 'success')) {
          const uData = data.user || data;
          localStorage.setItem('userToken', uData.token || 'auth-token');
          localStorage.setItem('username', uData.username || user);
          localStorage.setItem('userEmail', uData.email || '');
          localStorage.setItem('usuario_pwa', JSON.stringify(uData));
          
          document.getElementById('authModal').style.display = 'none';
          updateUIState();
      } else {
          msg.innerText = data.message || "Usuario o contraseña incorrectos.";
      }
  } catch (err) {
      console.error("Detalle del error:", err);
      msg.innerText = "Error al conectar con el servidor web (verificá que la base de datos y Apache estén activos).";
  }
}

  async function ejecutarRegistro() {
      const username = document.getElementById('regUser').value.trim();
      const email = document.getElementById('regEmail').value.trim();
      const password = document.getElementById('regPass').value.trim();
      const msg = document.getElementById('authMessage');

      if (!username || !password) {
          msg.innerText = "Por favor, completa los campos requeridos.";
          return;
      }

      try {
          const res = await fetch('register.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ username, email, password })
          });
          const data = await res.json();

          if (data.status === 'success' || data.success) {
              localStorage.setItem('userToken', data.token);
              localStorage.setItem('username', data.username);
              localStorage.setItem('userEmail', data.email);
              
              alert("Registro exitoso.");
              updateUIState();
          } else {
              msg.innerText = data.message || "No se pudo realizar el registro.";
          }
      } catch (err) {
          msg.innerText = "Error al conectar con el servidor.";
      }
  }

  // Todas las llamadas a la IA pasan por groq_proxy.php: la clave vive solo en el servidor.
  // Cierra la sesión local y pide iniciar sesión de nuevo (evita mostrar "logueado" con un token inválido)
  function sessionExpired(msg) {
    ['userToken', 'username', 'userEmail', 'usuario_pwa'].forEach(k => localStorage.removeItem(k));
    updateUIState();
    toggleAuthForms(true);
    openAuthModal();
    document.getElementById('authMessage').innerText = msg;
    const err = new Error(msg);
    err.code = 401;
    return err;
  }

  async function aiFetch(payload) {
    const token = localStorage.getItem('userToken');
    if (!token) throw sessionExpired('Iniciá sesión para usar la IA.');

    const resp = await fetch('groq_proxy.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-Auth-Token': token },
      body: JSON.stringify(payload)
    });

    // Solo se considera "sesión inválida" si el proxy lo indica explícitamente
    if (resp.status === 401) {
      let info = {};
      try { info = (await resp.clone().json()).error || {}; } catch (_) {}
      if (info.code === 'session_invalid') {
        throw sessionExpired(info.message || 'Tu sesión venció. Volvé a iniciar sesión.');
      }
    }
    return resp;
  }

  const BUILTIN_SOURCE = 'Base';
  const BUILTIN = [
    { q: "¿Cuál es el objeto de estudio de la microeconomía y qué tipo de problemas económicos analiza?", a: "La microeconomía estudia el comportamiento de agentes individuales —consumidores y empresas— y cómo toman decisiones sobre recursos escasos. Analiza la formación de precios, la producción y el consumo en mercados específicos." },
    { q: "¿Por qué el enfoque microeconómico es útil para comprender el mercado informático?", a: "Permite analizar cómo se forman los precios del hardware y software, cómo compiten las empresas tecnológicas y cómo los consumidores toman decisiones de compra, aplicando las leyes generales de oferta y demanda a un sector con características propias." },
    { q: "¿Qué se entiende por oferta en un mercado? Aplíquelo al sector informático.", a: "La oferta es la cantidad de bienes o servicios que los productores están dispuestos a vender a distintos precios. En informática abarca hardware, software and servicios tecnológicos que las empresas ponen a disposición del mercado." },
    { q: "¿Qué factores pueden influir en la oferta de productos o servicios tecnológicos?", a: "El costo de insumos, el nivel tecnológico de producción, la cantidad de empresas en el sector, las regulaciones impositivas y los avances en procesos de fabricación que permiten producir más a menor costo." },
    { q: "¿Qué se entiende por demanda y quiénes la integran en el mercado informático?", a: "La demanda es la cantidad de un bien que los consumidores están dispuestos a comprar a distintos precios. En el mercado informático la integran usuarios individuales, empresas, organismos públicos e instituciones educativas." },
    { q: "¿Qué factores influyen en el crecimiento o disminución de la demanda de tecnología?", a: "El nivel de ingresos, los cambios en preferencias, los precios de bienes sustitutos o complementarios, y el avance tecnológico que genera nuevas necesidades, como la digitalización de procesos productivos y educativos." },
    { q: "¿Cómo se relacionan oferta y demanda en la formación de precios?", a: "El precio de equilibrio se fija donde la cantidad ofrecida iguala a la demandada. Si la demanda supera a la oferta, los precios suben; si la oferta es mayor, bajan. Esta interacción determina el precio de mercado." },
    { q: "¿Qué características particulares tiene la fijación de precios en el sector del software?", a: "El costo de reproducción es casi nulo, lo que habilita estrategias flexibles: versiones freemium, suscripciones, licencias corporativas diferenciadas y descuentos por volumen, ya que el costo marginal de distribución es cercano a cero." },
    { q: "¿Qué se entiende por competencia dentro de un mercado económico?", a: "Es la rivalidad entre empresas que ofrecen productos similares y compiten por los mismos consumidores, en precio, calidad o innovación. El grado varía desde mercados muy competitivos hasta monopolios u oligopolios." },
    { q: "¿Qué beneficios genera la competencia entre empresas tecnológicas para los consumidores?", a: "Impulsa la innovación, reduce precios y mejora la calidad y variedad de productos. En tecnología se traduce en mejores equipos, software más eficiente y servicios de mayor valor a costos más accesibles." },
    { q: "¿Cómo se define la industria informática y qué actividades incluye?", a: "Comprende el conjunto de empresas y actividades vinculadas al desarrollo, producción, comercialización y soporte de tecnologías de la información: fabricación de hardware, desarrollo de software, servicios tecnológicos, telecomunicaciones y consultoría." },
    { q: "¿Por qué la industria informática está formada por múltiples sectores interrelacionados?", a: "Porque ningún componente funciona de forma aislada: el hardware necesita software para operar, el software requiere infraestructura de red para distribuirse, y los servicios dependen de ambos. Esta interdependencia genera una cadena de valor compleja." },
    { q: "¿Qué diferencias existen entre bienes y servicios informáticos?", a: "Los bienes son tangibles o digitales y se adquieren para uso directo (una computadora, un programa). Los servicios son intangibles y se consumen en el momento de su prestación, como soporte técnico, consultoría o mantenimiento." },
    { q: "Mencione tres roles laborales que puede desempeñar un técnico informático.", a: "Puede desempeñarse como soporte técnico, administrador de redes y asesor tecnológico (también como instalador de sistemas, vendedor especializado o emprendedor)." },
    { q: "¿Por qué la confianza del cliente es importante para un técnico independiente?", a: "Porque de esa confianza generada (a través de la calidad, responsabilidad y buena comunicación) depende la continuidad laboral y la construcción de su cartera de clientes, más que de las campañas publicitarias." },
    { q: "¿Qué se entiende por comercialización de hardware?", a: "Son todas las operaciones comerciales relacionadas con la compra, venta, distribución e instalación de equipamiento informático físico." },
    { q: "¿Cuál es la función principal de una licencia de software?", a: "Otorgar al cliente el derecho legal a utilizar un programa bajo determinadas condiciones establecidas por el fabricante, ya que el usuario no compra el programa en sí, sino ese derecho." },
    { q: "Explique las diferencias entre una licencia OEM y una licencia Retail.", a: "La licencia OEM viene preinstalada con el hardware, es más barata, pero queda unida para siempre a ese equipo y no se puede pasar a otro. La licencia Retail se compra por separado, es más flexible, cuesta más y sí se puede transferir a otro dispositivo siempre que no se use en más de uno a la vez." },
    { q: "Nombre al menos cuatro servicios informáticos que puede ofrecer un técnico.", a: "Puede ofrecer: reparación y mantenimiento de equipos, instalación de redes, soporte remoto y copias de seguridad (backup)." },
    { q: "¿Qué es un SLA y para qué sirve?", a: "Es un Acuerdo de Nivel de Servicio (una cláusula de contrato) que sirve para definir cómo se debe brindar un servicio, especificando cosas como los horarios de atención y el tiempo máximo de respuesta ante un problema. Protege tanto al cliente como al técnico." },
    { q: "¿Por qué es importante el soporte técnico postventa?", a: "Porque sirve para resolver fallas iniciales, capacitar al usuario y prevenir problemas futuros, siendo uno de los factores más importantes para lograr la fidelidad y futuras contrataciones del cliente." },
    { q: "¿Cuál es la función de una factura?", a: "Funciona como la prueba legal de que una venta o servicio fue realizado, registrando la operación ante el sistema fiscal con los datos del vendedor, comprador, precios e impuestos." },
    { q: "¿Cuándo se utiliza una nota de crédito?", a: "Se utiliza para modificar una factura ya emitida, sirviendo para corregir errores, registrar descuentos posteriores o devolver dinero si se canceló un servicio o se devolvió un producto fallado." },
    { q: "¿Qué información certifica un remito?", a: "Certifica la entrega física de un producto, verificando qué cosas se entregaron, en qué cantidad y en qué fecha." },
    { q: "¿Cuál es la finalidad de un presupuesto?", a: "Su finalidad es proponer una oferta económica previa al trabajo para orientar al cliente sobre los costos y tiempos de ejecución, evitando malentendidos. En Argentina se le suele poner fecha de vencimiento por la variación de precios." },
    { q: "¿Qué es el Monotributo?", a: "Es un régimen impositivo simplificado en Argentina destinado a pequeños contribuyentes con ingresos limitados, que unifica en un solo pago mensual los impuestos nacionales y los aportes jubilatorios." },
    { q: "¿Qué función cumple la AFIP?", a: "Es el organismo del Estado nacional encargado de administrar e inscribir los tributos nacionales y otorgar el CUIT a los contribuyentes." },
    { q: "¿Qué es el Impuesto al Valor Agregado (IVA)?", a: "Es un impuesto nacional que grava el consumo de bienes y servicios comerciales." },
    { q: "Encuentre las declaraciones juradas?", a: "Son informes periódicos y formales que el contribuyente presenta al Estado para comunicar sus ingresos, gastos y operaciones comerciales para poder calcular sus impuestos." },
    { q: "¿Por qué es importante la ética profesional en informática?", a: "Porque los técnicos tienen un acceso privilegiado a dispositivos y sistemas con información privada y sensible de las personas. Actuar con ética garantiza que se respete esa confianza, que no se use mal la información y que se trabaje de forma honesta y responsable." }
  ];

  const STORAGE_KEY = 'prueba_questions_v1';

  function loadBank() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      if (raw) return JSON.parse(raw);
    } catch(e) {}
    return BUILTIN.map(x => ({ ...x, source: BUILTIN_SOURCE, id: crypto.randomUUID() }));
  }
  function saveBank(b) { localStorage.setItem(STORAGE_KEY, JSON.stringify(b)); }

  let bank = loadBank();

  function updateStats() {
    const sources = [...new Set(bank.map(x => x.source))];
    document.getElementById('sidebar-stats').innerHTML =
      `<p><strong>${bank.length}</strong> preguntas</p>
       <p style="margin-top:4px">${sources.length} fuente${sources.length !== 1 ? 's' : ''}</p>`;
  }

  function showScreen(name) {
    document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
    document.getElementById('nav-' + name).classList.add('active');
    if (name === 'quiz') renderQuiz();
    else if (name === 'difficulty') renderDifficulty();
    else renderManage();
    updateStats();
  }

  // ── Dificultad ────────────────────────────────────────────────────────────────
  const DIFFICULTY_KEY = 'prueba_difficulty_v1';
  const DEFAULT_DIFFICULTY = {
    numQuestions: 'all',   // 'all' | 10 | 20 | 30 | 40
    timeLimit: 0,          // minutos, 0 = sin límite
    strictMode: false,     // margen de error reducido
    hideAnswer: false,     // ocultar la respuesta esperada al fallar
    passThreshold: 60      // % mínimo para considerar aprobada la prueba
  };

  function loadDifficulty() {
    try {
      const raw = localStorage.getItem(DIFFICULTY_KEY);
      if (raw) return { ...DEFAULT_DIFFICULTY, ...JSON.parse(raw) };
    } catch(e) {}
    return { ...DEFAULT_DIFFICULTY };
  }
  function saveDifficulty(d) { localStorage.setItem(DIFFICULTY_KEY, JSON.stringify(d)); }

  let diffSettings = loadDifficulty();

  function updateDifficulty(key, value) {
    diffSettings[key] = value;
    saveDifficulty(diffSettings);
  }

  function resetDifficulty() {
    diffSettings = { ...DEFAULT_DIFFICULTY };
    saveDifficulty(diffSettings);
    renderDifficulty();
  }

  function renderDifficulty() {
    const d = diffSettings;
    document.getElementById('main').innerHTML = `
      <div class="quiz-header">
        <h1>Dificultad de la prueba</h1>
        <p>Ajustá cómo se evalúa y cronometra cada intento</p>
      </div>

      <div class="q-card">
        <label style="display:block;font-size:13px;font-weight:500;margin-bottom:6px">Cantidad de preguntas</label>
        <p style="font-size:12px;color:var(--muted);margin-bottom:10px">Cuántas preguntas del banco se sortean por intento (hay ${bank.length} disponibles).</p>
        <select id="cfgNumQuestions" onchange="updateDifficulty('numQuestions', this.value === 'all' ? 'all' : parseInt(this.value))"
          style="background:#131313;border:0.5px solid var(--border);border-radius:8px;color:var(--text);font-size:13px;padding:0.5rem 0.75rem;font-family:inherit">
          <option value="all" ${d.numQuestions==='all'?'selected':''}>Todas</option>
          <option value="10" ${d.numQuestions===10?'selected':''}>10 preguntas</option>
          <option value="20" ${d.numQuestions===20?'selected':''}>20 preguntas</option>
          <option value="30" ${d.numQuestions===30?'selected':''}>30 preguntas</option>
          <option value="40" ${d.numQuestions===40?'selected':''}>40 preguntas</option>
        </select>
      </div>

      <div class="q-card">
        <label style="display:block;font-size:13px;font-weight:500;margin-bottom:6px">Tiempo límite</label>
        <p style="font-size:12px;color:var(--muted);margin-bottom:10px">Si se acaba el tiempo, la prueba se cierra automáticamente y se muestran los resultados.</p>
        <select id="cfgTimeLimit" onchange="updateDifficulty('timeLimit', parseInt(this.value))"
          style="background:#131313;border:0.5px solid var(--border);border-radius:8px;color:var(--text);font-size:13px;padding:0.5rem 0.75rem;font-family:inherit">
          <option value="0" ${d.timeLimit===0?'selected':''}>Sin límite</option>
          <option value="5" ${d.timeLimit===5?'selected':''}>5 minutos</option>
          <option value="10" ${d.timeLimit===10?'selected':''}>10 minutos</option>
          <option value="15" ${d.timeLimit===15?'selected':''}>15 minutos</option>
          <option value="20" ${d.timeLimit===20?'selected':''}>20 minutos</option>
          <option value="30" ${d.timeLimit===30?'selected':''}>30 minutos</option>
        </select>
      </div>

      <div class="q-card">
        <label style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:500;cursor:pointer">
          <input type="checkbox" id="cfgStrict" ${d.strictMode?'checked':''} onchange="updateDifficulty('strictMode', this.checked)">
          Margen de error reducido (modo estricto)
        </label>
        <p style="font-size:12px;color:var(--muted);margin-top:6px">La IA corrige de forma más exigente y las respuestas "parciales" ya no suman medio punto: cuentan como incorrectas en el puntaje final.</p>
      </div>

      <div class="q-card">
        <label style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:500;cursor:pointer">
          <input type="checkbox" id="cfgHideAnswer" ${d.hideAnswer?'checked':''} onchange="updateDifficulty('hideAnswer', this.checked)">
          Ocultar la respuesta esperada al fallar
        </label>
        <p style="font-size:12px;color:var(--muted);margin-top:6px">No muestra la respuesta correcta en el momento ni en el resumen final — simula mejor un examen real.</p>
      </div>

      <div class="q-card">
        <label style="display:block;font-size:13px;font-weight:500;margin-bottom:6px">Puntaje mínimo para aprobar</label>
        <p style="font-size:12px;color:var(--muted);margin-bottom:10px">Define a partir de qué porcentaje se considera "aprobado" el intento en la pantalla de resultados.</p>
        <select id="cfgPassThreshold" onchange="updateDifficulty('passThreshold', parseInt(this.value))"
          style="background:#131313;border:0.5px solid var(--border);border-radius:8px;color:var(--text);font-size:13px;padding:0.5rem 0.75rem;font-family:inherit">
          <option value="50" ${d.passThreshold===50?'selected':''}>50%</option>
          <option value="60" ${d.passThreshold===60?'selected':''}>60%</option>
          <option value="70" ${d.passThreshold===70?'selected':''}>70%</option>
          <option value="80" ${d.passThreshold===80?'selected':''}>80%</option>
          <option value="90" ${d.passThreshold===90?'selected':''}>90%</option>
        </select>
      </div>

      <div class="actions">
        <button class="btn btn-ghost" onclick="resetDifficulty()">Restaurar valores por defecto</button>
      </div>`;
  }

  // ── Quiz ──────────────────────────────────────────────────────────────────────
  let qList = [], qIdx = 0, qResults = [], evaluating = false;

  // ── Cronómetro ─────────────────────────────────────────────
  let quizStartTime = null;
  let timerInterval = null;
  let elapsedSeconds = 0;
  let timerStarted = false;
  let timeIsUp = false;

  function shuffle(arr) {
    const a = [...arr];
    for (let i = a.length-1; i > 0; i--) {
      const j = Math.floor(Math.random()*(i+1));
      [a[i],a[j]] = [a[j],a[i]];
    }
    return a;
  }

  function formatTime(totalSeconds) {
    const h = Math.floor(totalSeconds / 3600);
    const m = Math.floor((totalSeconds % 3600) / 60);
    const s = totalSeconds % 60;

    return [
      String(h).padStart(2, '0'),
      String(m).padStart(2, '0'),
      String(s).padStart(2, '0')
    ].join(':');
  }

  function startTimer() {
    if (timerStarted) return;

    timerStarted = true;
    quizStartTime = Date.now();
    elapsedSeconds = 0;

    document.getElementById('timerBox')?.classList.add('active');

    clearInterval(timerInterval);

    const limitSeconds = diffSettings.timeLimit > 0 ? diffSettings.timeLimit * 60 : 0;

    timerInterval = setInterval(() => {
      elapsedSeconds = Math.floor((Date.now() - quizStartTime) / 1000);
      const el = document.getElementById('timerDisplay');

      if (limitSeconds > 0) {
        const remaining = Math.max(0, limitSeconds - elapsedSeconds);
        if (el) {
          el.textContent = formatTime(remaining);
          document.getElementById('timerBox')?.classList.toggle('low-time', remaining <= 30);
        }
        if (remaining <= 0) {
          clearInterval(timerInterval);
          handleTimeUp();
          return;
        }
      } else if (el) {
        el.textContent = formatTime(elapsedSeconds);
      }
    }, 1000);
  }

  function stopTimer() {
    clearInterval(timerInterval);
    if (quizStartTime) elapsedSeconds = Math.floor((Date.now() - quizStartTime) / 1000);
  }

  function handleTimeUp() {
    timeIsUp = true;
    for (let i = qIdx; i < qList.length; i++) {
      if (qResults[i] === undefined) qResults[i] = 'incorrecto';
    }
    stopTimer();
    renderResults();
  }

  function startQuiz() {
    qList = shuffle(bank);
    if (diffSettings.numQuestions !== 'all') {
      qList = qList.slice(0, diffSettings.numQuestions);
    }
    qIdx = 0;
    qResults = [];
    evaluating = false;

    timerStarted = false;
    quizStartTime = null;
    elapsedSeconds = 0;
    timeIsUp = false;
    clearInterval(timerInterval);

    renderQ();
  }

  function renderQuiz() {
    if (bank.length === 0) {
      document.getElementById('main').innerHTML = `
        <div class="empty-state"><div class="icon">📭</div>
          <p>No hay preguntas. Agregá un archivo en "Gestionar preguntas".</p>
          <button class="btn btn-ghost" style="margin-top:1rem" onclick="showScreen('manage')">Ir a Gestionar</button>
        </div>`;
      return;
    }
    startQuiz();
  }

  function renderQ() {
    const total = qList.length;
    const q = qList[qIdx];
    const pct = (qIdx / total * 100).toFixed(1);
    const dots = qList.map((_, i) => {
      const r = qResults[i];
      let cls = 'dot' + (i === qIdx ? ' cur' : r === 'correcto' ? ' ok' : r === 'parcial' ? ' half' : r === 'incorrecto' ? ' bad' : i < qIdx ? ' done' : '');
      return `<div class="${cls}"></div>`;
    }).join('');

    document.getElementById('main').innerHTML = `
        <div class="quiz-header">
        <div id="timerBox" class="timer-box ${timerStarted ? 'active' : ''}">
          <span class="timer-label">⏱ ${diffSettings.timeLimit > 0 ? 'Tiempo restante' : 'Tiempo'}</span>
          <span id="timerDisplay" class="timer-display">
            ${diffSettings.timeLimit > 0 && !timerStarted ? formatTime(diffSettings.timeLimit * 60) : formatTime(elapsedSeconds)}
          </span>
        </div>

        <h1>Prueba escrita</h1>
        <p>Respondé con tus palabras — la IA evalúa semánticamente</p>
      </div>

      <div class="progress-wrap"><div class="progress-fill" style="width:${pct}%"></div></div>
      <div class="q-meta">
        <span class="q-num">Pregunta ${qIdx+1} de ${total}</span>
        <div class="dots">${dots}</div>
      </div>
      <div class="q-card">
        <div class="q-source">${q.source || 'Base'}</div>
        <div class="q-text">${q.q}</div>
        <textarea id="ans" placeholder="Escribí tu respuesta... (Ctrl+Enter para verificar)"></textarea>
      </div>
      <div id="fb"></div>
      <div class="actions">
        <button class="btn btn-primary" id="btnCheck" onclick="checkAns()">Verificar</button>
        <button class="btn btn-ghost" style="display:none" id="btnNext" onclick="nextQ()">Siguiente →</button>
        <button class="btn-skip-txt" onclick="skipQ()">Omitir pregunta</button>
      </div>`;

    const ta = document.getElementById('ans');
    ta.focus();
    ta.addEventListener('keydown', e => {
      if (e.key === 'Enter' && e.ctrlKey) {
        e.preventDefault();
        const btnNext = document.getElementById('btnNext');
        if (btnNext && btnNext.style.display !== 'none') {
          nextQ();
        } else {
          checkAns();
        }
      }
    });
  }

  async function checkAns() {
    const boton = document.getElementById('btnCheck'); 
    if (!boton || boton.disabled) return; 

    const ansInput = document.getElementById('ans');
    const ans = ansInput ? ansInput.value.trim() : '';

    if (!ans) return;

    if (!timerStarted) {
      startTimer();
    }

    boton.disabled = true;
    boton.innerText = "Corrigiendo...";
    
    const fb = document.getElementById('fb');
    fb.innerHTML = `<div class="feedback loading"><div class="spinner"></div> Evaluando respuesta con IA...</div>`;
    
    const q = qList[qIdx];
    
    try {
      const promptText = `Eres un profesor técnico experto evaluando respuestas de exámenes sobre Mercado Informático y Normativa Impositiva Argentina.
Compara la "Respuesta del Alumno" contra la "Respuesta Correcta Esperada". Evalúa semánticamente el fondo de la cuestión, no la literalidad.
${diffSettings.strictMode ? 'MODO ESTRICTO ACTIVADO: sé exigente. Marca "correcto" únicamente si la respuesta cubre todos los conceptos clave sin omisiones ni imprecisiones. Cualquier respuesta incompleta, vaga o con errores conceptuales debe marcarse como "parcial" o "incorrecto", nunca "correcto".' : ''}

Pregunta: "${q.q}"
Respuesta Correcta Esperada: "${q.a}"
Respuesta del Alumno: "${ans}"

Devuelve únicamente un objeto JSON puro (sin bloques markdown \`\`\`json) con el siguiente formato exacto:
{
  "resultado": "correcto" | "parcial" | "incorrecto",
  "explicacion": "Una crítica concisa y constructiva (máximo 2 frases) de lo que respondió el alumno.",
  "consejo": "Un consejo pedagógico muy breve si la respuesta fue parcial o incorrecta. Si es totalmente correcta, este campo puede ir vacío o nulo."
}`;

      const resp = await aiFetch({
        reasoning_effort: 'low',
        max_tokens: 2048,
        messages: [{ role: 'user', content: promptText }]
      });

      if (!resp.ok) {
        throw new Error(`Error en API: ${resp.status} ${resp.statusText}`);
      }

      const data = await resp.json();
      let raw = data.choices[0].message.content.trim();
      raw = raw.replace(/```json|```/g, '').trim();
      
      const { resultado, explicacion, consejo } = JSON.parse(raw);
      qResults[qIdx] = resultado;
      
      const clsMap = { correcto:'ok', parcial:'half', incorrecto:'bad' };
      const iconMap = { correcto:'✓', parcial:'◐', incorrecto:'✗' };
      const labelMap = { correcto:'Correcto', parcial:'Parcialmente correcto', incorrecto:'Incorrecto' };
      
      fb.innerHTML = `<div class="feedback ${clsMap[resultado]}">
        <span class="fb-label">${iconMap[resultado]} ${labelMap[resultado]}</span>
        ${explicacion}
        ${consejo ? `<div class="fb-detail">💡 ${consejo}</div>` : ''}
        ${resultado !== 'correcto' && !diffSettings.hideAnswer ? `<div class="fb-detail">Respuesta esperada: ${q.a}</div>` : ''}
      </div>`;
      
      boton.style.display = 'none';
      const btnN = document.getElementById('btnNext');
      btnN.style.display = 'inline-flex';
      btnN.textContent = qIdx < qList.length - 1 ? 'Siguiente →' : 'Ver resultados →';
    } catch(e) {
      console.error(e);
      const msgErr = e.code === 401 ? e.message : 'No se pudo procesar la respuesta. Verifica tu conexión o intenta más tarde.';
      fb.innerHTML = `<div class="feedback bad"><span class="fb-label">Error de Comunicación</span>${msgErr}</div>`;
    } finally {
      boton.disabled = false;
      boton.innerText = "Verificar";
    }
  }

  function skipQ() { qResults[qIdx] = 'incorrecto'; nextQ(); }
  function nextQ() { qIdx++; if (qIdx >= qList.length) renderResults(); else renderQ(); }

  function renderResults() {
    stopTimer();
    const total = qList.length;
    const ok = qResults.filter(r=>r==='correcto').length;
    const half = qResults.filter(r=>r==='parcial').length;
    const bad = qResults.filter(r=>r==='incorrecto').length;
    const halfWeight = diffSettings.strictMode ? 0 : 0.5;
    const score = ok + Math.round(half*halfWeight);
    const pct = Math.round(score/total*100);
    const threshold = diffSettings.passThreshold;
    const msg = pct>=threshold ? (pct>=90?'¡Excelente!':'¡Aprobado!') : 'No alcanzaste el mínimo — seguí practicando';
    const wrongs = qList.map((q,i)=>({q,r:qResults[i]})).filter(x=>x.r!=='correcto');

    document.getElementById('main').innerHTML = `
      <div class="results-top">
        <div class="ring"><div class="ring-n">${score}</div><div class="ring-d">de ${total}</div></div>
        <h2>${msg}</h2>
        <p>${ok} correctas · ${half} parciales · ${bad} incorrectas${diffSettings.strictMode ? ' (modo estricto: parciales no suman)' : ''}</p>
        <p style="font-size:12px;color:var(--muted);margin-top:0.2rem">Mínimo para aprobar: ${threshold}%</p>
        ${timeIsUp ? `<p style="margin-top:0.4rem;color:var(--error);font-weight:600;font-size:13px">⏱ Tiempo agotado — las preguntas sin responder cuentan como incorrectas</p>` : ''}
        <p style="margin-top:0.5rem;color:var(--accent);font-weight:600;font-size:14px">
          ⏱ Tiempo total: ${formatTime(elapsedSeconds)}
        </p>
      </div>
      ${wrongs.length ? `
        <div class="section-hd">Para repasar (${wrongs.length})</div>
        ${wrongs.map(x=>`<div class="wrong-card">
          <div class="tag">${x.q.source||'Base'}</div>
          <div class="wrong-q">${x.q.q}</div>
          ${diffSettings.hideAnswer ? '' : `<div class="wrong-a"><span class="wrong-lbl">Respuesta:</span>${x.q.a}</div>`}
        </div>`).join('')}
      ` : `<p style="color:var(--success);text-align:center;padding:2rem">¡Todo correcto!</p>`}
      <div class="actions" style="justify-content:center;margin-top:2rem">
        <button class="btn btn-primary" onclick="startQuiz()">Hacer otra vez</button>
        <button class="btn btn-ghost" onclick="showScreen('manage')">Gestionar preguntas</button>
      </div>`;
  }

  // ── Manage ────────────────────────────────────────────────────────────────────
  let manageFilter = '';

  function renderManage() {
    const filtered = bank.filter(x =>
      !manageFilter ||
      x.q.toLowerCase().includes(manageFilter.toLowerCase()) ||
      (x.source||'').toLowerCase().includes(manageFilter.toLowerCase())
    );
    const hasCustom = bank.some(x => x.source !== BUILTIN_SOURCE);

    document.getElementById('main').innerHTML = `
      <div class="manage-header">
        <h1>Gestionar preguntas</h1>
        <p>Subí archivos de cualquier tipo para agregar mas preguntas al banco</p>
      </div>
      <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()"
        ondragover="event.preventDefault();this.classList.add('drag')"
        ondragleave="this.classList.remove('drag')"
        ondrop="handleDrop(event)">
        <div class="uz-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3v12"/>
            <path d="M7 10l5 5 5-5"/>
            <path d="M5 21h14"/>
          </svg>
        </div>
        <h3>Subí un archivo</h3>
        <p>La IA extrae las preguntas y respuestas automáticamente</p>
        <span class="uz-browse">Elegir archivo</span>
        <span class="uz-format">PDF · Word · PowerPoint · Excel · CSV · TXT · MD · HTML · JSON · ODT — o arrastralo acá</span>
      </div>
      <input type="file" id="fileInput" accept=".docx,.pdf,.pptx,.xlsx,.xls,.csv,.odt,.txt,.md,.html,.htm,.json" style="display:none" onchange="handleFile(this.files[0]); this.value='';">
      <div id="uploadStatus"></div>
      <div class="filter-row">
        <input type="text" placeholder="Buscar pregunta o fuente..." value="${manageFilter}"
          oninput="manageFilter=this.value;renderManage()" />
        <span class="count-badge">${filtered.length} de ${bank.length}</span>
        <button class="btn btn-ghost btn-sm" onclick="showAddModal()">+</button>
        ${hasCustom ? `<button class="btn btn-danger btn-sm" onclick="clearCustom()">Borrar importadas</button>` : ''}
      </div>
      <div class="bank-list">
        ${filtered.length === 0 ? `<div class="empty-state"><p>Sin resultados</p></div>` :
          filtered.map(item => `
            <div class="bank-item" id="item-${item.id}">
              <div class="bank-item-body">
                <div class="bank-item-src">${item.source||'Base'}</div>
                <div class="bank-item-q">${item.q}</div>
                <div class="bank-item-a">${item.a}</div>
              </div>
              <div class="bank-actions">
                <button class="btn btn-ghost btn-sm" onclick="showEditModal('${item.id}')">Editar</button>
                <button class="btn btn-danger btn-sm" onclick="deleteItem('${item.id}')">✕</button>
              </div>
            </div>`).join('')}
      </div>`;
  }

  function showUploadStatus(type, html) {
    const status = document.getElementById('uploadStatus');
    if (!status) return;
    const icons = {
      loading: '<div class="spinner"></div>',
      success: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>',
      error: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>'
    };
    status.className = 'upload-status ' + type;
    status.innerHTML = `<span class="us-icon">${icons[type]}</span> ${html}`;
  }

  function handleDrop(e) {
    e.preventDefault();
    document.getElementById('uploadZone').classList.remove('drag');
    const file = e.dataTransfer.files[0];
    if (!file) return;
    handleFile(file);
  }

  // Divide el texto en partes chicas (por párrafos) para no pasarse del límite de tokens de la API
  function splitText(text, maxChars = 5000) {
    const paragraphs = text.split(/\n+/).map(p => p.trim()).filter(Boolean);
    const chunks = [];
    let current = '';
    for (const p of paragraphs) {
      if (current && (current.length + p.length + 1) > maxChars) {
        chunks.push(current);
        current = '';
      }
      current += (current ? '\n' : '') + p;
    }
    if (current) chunks.push(current);
    return chunks;
  }

  function parseQAArray(raw) {
    raw = raw.replace(/```json|```/gi, '').trim();
    const s = raw.indexOf('['), e = raw.lastIndexOf(']');
    if (s === -1 || e === -1 || e < s) throw new Error('La IA no devolvió una lista de preguntas válida.');
    return JSON.parse(raw.slice(s, e + 1));
  }

  const sleep = ms => new Promise(r => setTimeout(r, ms));

  // Llama a Groq con reintentos si hay límite de velocidad (429)
  async function callGroq(promptText, retries = 3) {
    for (let attempt = 0; attempt <= retries; attempt++) {
      const resp = await aiFetch({
        temperature: 0,
        reasoning_effort: 'low',
        max_tokens: 4096,
        messages: [{ role: 'user', content: promptText }]
      });

      if (resp.status === 429 && attempt < retries) {
        const wait = (parseFloat(resp.headers.get('retry-after')) || 20) * 1000;
        showUploadStatus('loading', `Límite de la API alcanzado, reintentando en ${Math.ceil(wait / 1000)} s...`);
        await sleep(wait);
        continue;
      }

      if (!resp.ok) {
        let detail = '';
        try { const j = await resp.json(); detail = j.error?.message || j.message || ''; } catch (_) {}
        throw new Error(`API ${resp.status}${detail ? ': ' + detail : ''}`);
      }

      const data = await resp.json();
      return data.choices[0].message.content.trim();
    }
  }

  // ── Lectura de distintos formatos ───────────────────────────────────────────
  const SUPPORTED_EXT = ['docx','pdf','pptx','xlsx','xls','csv','odt','txt','md','html','htm','json'];
  const MAX_FILE_MB = 20;
  const MAX_CHUNKS = 40;
  const LIB_URLS = {
    pdf:       'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js',
    pdfWorker: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js',
    xlsx:      'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js',
    jszip:     'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js'
  };
  const _libPromises = {};

  // Las librerías pesadas se cargan recién cuando hacen falta
  function loadLib(name) {
    if (!_libPromises[name]) {
      _libPromises[name] = new Promise((resolve, reject) => {
        const el = document.createElement('script');
        el.src = LIB_URLS[name];
        el.onload = resolve;
        el.onerror = () => {
          delete _libPromises[name];
          reject(new Error('No se pudo cargar una librería necesaria. Revisá tu conexión a internet.'));
        };
        document.head.appendChild(el);
      });
    }
    return _libPromises[name];
  }

  function decodeText(buf) {
    try { return new TextDecoder('utf-8', { fatal: true }).decode(buf); }
    catch (_) { return new TextDecoder('windows-1252').decode(buf); } // CSV/TXT viejos de Windows
  }

  function xmlToText(xml, breakRegex) {
    const t = xml.replace(breakRegex, '\n').replace(/<[^>]+>/g, '');
    const ta = document.createElement('textarea'); // decodifica &amp; &lt; etc. sin ejecutar nada
    ta.innerHTML = t;
    return ta.value;
  }

  async function extractText(ext, buf) {
    switch (ext) {
      case 'docx': {
        if (typeof mammoth === 'undefined') throw new Error('No se cargó la librería para leer Word (revisá tu conexión).');
        return (await mammoth.extractRawText({ arrayBuffer: buf })).value;
      }
      case 'pdf': {
        await loadLib('pdf');
        pdfjsLib.GlobalWorkerOptions.workerSrc = LIB_URLS.pdfWorker;
        const pdf = await pdfjsLib.getDocument({ data: new Uint8Array(buf) }).promise;
        let out = '';
        for (let i = 1; i <= pdf.numPages; i++) {
          showUploadStatus('loading', `Leyendo PDF... página ${i} de ${pdf.numPages}`);
          const page = await pdf.getPage(i);
          const content = await page.getTextContent();
          out += content.items.map(it => it.str + (it.hasEOL ? '\n' : ' ')).join('') + '\n';
        }
        if (!out.trim()) throw new Error('El PDF no tiene texto seleccionable (parece escaneado). Probá con otro formato.');
        return out;
      }
      case 'pptx': {
        await loadLib('jszip');
        const zip = await JSZip.loadAsync(buf);
        const slides = Object.keys(zip.files)
          .filter(n => /^ppt\/slides\/slide\d+\.xml$/.test(n))
          .sort((a, b) => parseInt(a.match(/(\d+)\.xml$/)[1]) - parseInt(b.match(/(\d+)\.xml$/)[1]));
        let out = '';
        for (let i = 0; i < slides.length; i++) {
          const xml = await zip.files[slides[i]].async('string');
          out += `Diapositiva ${i + 1}:\n` + xmlToText(xml, /<\/a:p>/g) + '\n';
        }
        return out;
      }
      case 'odt': {
        await loadLib('jszip');
        const zip = await JSZip.loadAsync(buf);
        if (!zip.files['content.xml']) throw new Error('El archivo ODT no tiene contenido legible.');
        return xmlToText(await zip.files['content.xml'].async('string'), /<\/text:(p|h)>|<text:line-break\/>/g);
      }
      case 'xlsx':
      case 'xls': {
        await loadLib('xlsx');
        const wb = XLSX.read(buf, { type: 'array' });
        return wb.SheetNames
          .map(n => `Hoja: ${n}\n` + XLSX.utils.sheet_to_csv(wb.Sheets[n], { blankrows: false }))
          .join('\n\n');
      }
      case 'html':
      case 'htm': {
        const doc = new DOMParser().parseFromString(decodeText(buf), 'text/html');
        doc.querySelectorAll('script,style,noscript').forEach(el => el.remove());
        doc.querySelectorAll('p,div,li,tr,br,h1,h2,h3,h4,h5,h6').forEach(el => el.append('\n'));
        return doc.body ? doc.body.textContent : '';
      }
      default: // txt, md, csv, json
        return decodeText(buf);
    }
  }

  async function handleFile(file) {
    if (!file) return;
    const ext = (file.name.split('.').pop() || '').toLowerCase();

    if (!SUPPORTED_EXT.includes(ext)) {
      const hint = ext === 'doc' ? ' Los .doc viejos no se pueden leer: abrilo en Word y guardalo como .docx o PDF.' : '';
      showUploadStatus('error', `Formato ".${ext}" no soportado.${hint} Formatos válidos: ${SUPPORTED_EXT.map(e => '.' + e).join(', ')}`);
      return;
    }
    if (file.size > MAX_FILE_MB * 1024 * 1024) {
      showUploadStatus('error', `El archivo pesa más de ${MAX_FILE_MB} MB. Dividilo en partes más chicas.`);
      return;
    }

    showUploadStatus('loading', `Leyendo "${file.name}"...`);

    try {
      const buf = await file.arrayBuffer();
      const text = (await extractText(ext, buf)).replace(/\r/g, '').trim();
      if (!text) throw new Error('No se encontró texto en el archivo.');

      const sourceName = file.name.replace(/\.[^.]+$/, '');
      const chunks = splitText(text);
      if (chunks.length > MAX_CHUNKS) {
        throw new Error(`El documento es muy largo (${chunks.length} partes). Dividilo en archivos más chicos (máx. ${MAX_CHUNKS} partes).`);
      }
      const found = [];

      for (let i = 0; i < chunks.length; i++) {
        showUploadStatus('loading', `Procesando con IA... parte ${i + 1} de ${chunks.length}`);
        const promptText = `Analiza el siguiente texto extraído de un documento y extrae todas las preguntas, en caso de que no las alla ninguna pregunta formala en base a la informacion, buscando abarcar toda la informacion dada en el archivo con sus respectivas respuestas correctas. Puede haber preguntas numeradas seguidas de su respuesta, formato "P:/R:", o párrafos alternados de pregunta y respuesta. Si una pregunta no tiene respuesta completa en el texto, omítela.\n\nTexto:\n${chunks[i]}\n\nResponde ÚNICAMENTE con un array JSON puro, sin explicaciones ni bloques de código, con esta estructura exacta:\n[{"q": "pregunta 1", "a": "respuesta 1"}, {"q": "pregunta 2", "a": "respuesta 2"}]`;
        const raw = await callGroq(promptText);
        try {
          found.push(...parseQAArray(raw));
        } catch (err) {
          console.warn(`Parte ${i + 1}: no se pudo interpretar la respuesta`, raw, err);
        }
      }

      // Limpiar y evitar duplicados (también contra el banco actual)
      const existing = new Set(bank.map(x => x.q.trim().toLowerCase()));
      const nuevos = [];
      for (const item of found) {
        if (!item || typeof item.q !== 'string' || typeof item.a !== 'string') continue;
        const q = item.q.trim(), a = item.a.trim();
        if (!q || !a || existing.has(q.toLowerCase())) continue;
        existing.add(q.toLowerCase());
        nuevos.push({ id: crypto.randomUUID(), q, a, source: sourceName });
      }

      if (nuevos.length === 0) {
        throw new Error('No se detectaron preguntas nuevas en el documento.');
      }

      bank.push(...nuevos);
      saveBank(bank);
      renderManage();
      updateStats();
      showUploadStatus('success', `Se importaron ${nuevos.length} preguntas desde "${file.name}"`);
    } catch (err) {
      console.error(err);
      showUploadStatus('error', `Error al procesar el archivo: ${err.message || 'revisá la consola (F12).'}`);
    }
  }

  function deleteItem(id) {
    bank = bank.filter(x => x.id !== id);
    saveBank(bank); renderManage(); updateStats();
  }

  function clearCustom() {
    if (!confirm('¿Borrar todas las preguntas importadas (se conservan las de base)?')) return;
    bank = bank.filter(x => x.source === BUILTIN_SOURCE);
    saveBank(bank); renderManage(); updateStats();
  }

  // ── Modals ────────────────────────────────────────────────────────────────────
  function showAddModal() { showModal('Nueva pregunta', '', '', null); }
  function showEditModal(id) {
    const item = bank.find(x => x.id === id);
    if (!item) return;
    showModal('Editar pregunta', item.q, item.a, id);
  }

  function showModal(title, q, a, id) {
    const el = document.createElement('div');
    el.className = 'modal-overlay'; el.id = 'modal';
    el.innerHTML = `
      <div class="modal-box">
        <h3>${title}</h3>
        <label style="display:block;margin-top:10px;font-size:12px;color:var(--muted)">Pregunta</label>
        <textarea id="mq" rows="3">${q}</textarea>
        <label style="display:block;margin-top:10px;font-size:12px;color:var(--muted)">Respuesta</label>
        <textarea id="ma" rows="3">${a}</textarea>
        <div class="actions" style="margin-top:15px;justify-content:flex-end">
          <button class="btn btn-ghost" onclick="closeModal()">Cancelar</button>
          <button class="btn btn-primary" onclick="saveModal('${id||''}')">Guardar</button>
        </div>
      </div>`;
    document.body.appendChild(el);
    el.addEventListener('click', e => { if (e.target === el) closeModal(); });
  }

  function closeModal() { document.getElementById('modal')?.remove(); }
  function saveModal(id) {
    const q = document.getElementById('mq').value.trim();
    const a = document.getElementById('ma').value.trim();
    if (!q || !a) return;
    if (id) {
      bank = bank.map(x => x.id === id ? { ...x, q, a } : x);
    } else {
      bank.push({ q, a, source: 'Manual', id: crypto.randomUUID() });
    }
    saveBank(bank); closeModal(); renderManage(); updateStats();
  }

  // ── Inicialización ────────────────────────────────────────────────────────────
  document.addEventListener('DOMContentLoaded', () => {
    updateUIState();
    updateStats();
    renderQuiz();
  });

  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('sw.js')
        .then(reg => console.log('Service Worker registrado con éxito', reg))
        .catch(err => console.warn('Error al registrar el Service Worker', err));
    });
  }
</script>
</body>
</html>