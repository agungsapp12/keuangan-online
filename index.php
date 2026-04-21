<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<style>
/* RESET */
*,
*::before,
*::after {
  box-sizing: border-box;
}

/* FIX LAYOUT */
html, body {
  margin:0;
  padding:0;
  overflow-x:hidden;
}

/* BODY */
body {
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(135deg,#667eea,#764ba2);
  color:white;
}

/* CONTAINER */
.container {
  width:100%;
  max-width:1100px;
  margin:auto;
  padding:20px;
}

/* HEADER */
.header {
  text-align:center;
  margin-bottom:25px;
}

.header h1 {
  font-size:26px;
}

.header p {
  font-size:14px;
  opacity:0.9;
}

/* GRID */
.grid {
  display:grid;
  grid-template-columns: repeat(auto-fit, minmax(240px,1fr));
  gap:16px;
}

/* CARD */
.card {
  width:100%;
  background:white;
  color:#333;
  padding:20px;
  border-radius:16px;
  cursor:pointer;
  text-align:center;
  box-shadow:0 8px 20px rgba(0,0,0,0.15);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
  transform: translateY(-4px);
}

/* ICON */
.icon {
  font-size:38px;
  margin-bottom:10px;
}

/* TEXT */
.card h2 {
  font-size:18px;
  margin-bottom:5px;
}

.card p {
  font-size:13px;
  color:#666;
}

/* MOBILE */
@media (max-width:480px){
  .container {
    padding:15px;
  }

  .card {
    padding:18px;
  }

  .header h1 {
    font-size:22px;
  }
}
</style>
</head>

<body>

<div class="container">

  <div class="header">
    <h1>📚 Dashboard</h1>
    <p>Pilih menu sistem pembelajaran</p>
  </div>

  <div class="grid">

    <!-- BUAT SOAL -->
    <div class="card" onclick="goTo('buat_soal.php')">
      <div class="icon">✏️</div>
      <h2>Buat Soal</h2>
      <p>Guru membuat soal essay</p>
    </div>

    <!-- JAWAB SOAL -->
    <div class="card" onclick="goTo('jawab_soal.php')">
      <div class="icon">📝</div>
      <h2>Jawab Soal</h2>
      <p>Siswa mengerjakan soal</p>
    </div>

    <!-- VOCAB -->
    <div class="card" onclick="goTo('vocab.php')">
      <div class="icon">📖</div>
      <h2>Vocabulary</h2>
      <p>Kelola kosakata bahasa Inggris</p>
    </div>

  </div>

</div>

<script>
function goTo(page){
  window.location.href = page;
}
</script>

</body>
</html>