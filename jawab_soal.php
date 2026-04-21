<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jawab Soal</title>

<style>
body {
  font-family: Arial;
  background: linear-gradient(135deg,#667eea,#764ba2);
  padding:15px;
  margin:0;
}

.container {
  max-width:900px;
  margin:auto;
}

.card {
  background:white;
  padding:15px;
  border-radius:10px;
}

.back-btn {
  width:100%;
  padding:10px;
  background:#444;
  color:white;
  border:none;
  border-radius:6px;
  margin-bottom:10px;
}

/* FILTER */
.filter-box {
  display:flex;
  gap:10px;
  flex-wrap:wrap;
  margin-bottom:10px;
}

select {
  flex:1;
  min-width:120px;
  padding:8px;
  border-radius:6px;
}

/* BUTTON */
.btn-filter {
  width:100%;
  padding:10px;
  background:#28a745;
  color:white;
  border:none;
  border-radius:6px;
  margin-bottom:15px;
}

/* GRID */
.grid {
  display:grid;
  grid-template-columns: repeat(auto-fill, minmax(160px,1fr));
  gap:12px;
}

.box {
  background:#f5f5f5;
  padding:15px;
  border-radius:10px;
  cursor:pointer;
}

.status {
  display:inline-block;
  margin-top:8px;
  padding:4px 8px;
  border-radius:5px;
  font-size:12px;
}

.belum { background:#ffc107; }
.sudah { background:#28a745; color:white; }
</style>
</head>

<body>

<div class="container">
  <div class="card">

    <button class="back-btn" onclick="goBack()">← Kembali</button>

    <h2>List Soal</h2>

    <div class="filter-box">
      <select id="filterTahun">
        <option value="">Semua Tahun</option>
      </select>

      <select id="filterBulan">
        <option value="">Semua Bulan</option>
        <option value="01">Jan</option>
        <option value="02">Feb</option>
        <option value="03">Mar</option>
        <option value="04">Apr</option>
        <option value="05">Mei</option>
        <option value="06">Jun</option>
        <option value="07">Jul</option>
        <option value="08">Agu</option>
        <option value="09">Sep</option>
        <option value="10">Okt</option>
        <option value="11">Nov</option>
        <option value="12">Des</option>
      </select>
    </div>

    <button class="btn-filter" onclick="applyFilter()">Terapkan Filter</button>

    <div id="grid" class="grid"></div>

  </div>
</div>

<script>
const URL = "https://script.google.com/macros/s/AKfycbw68aPZL-ZfP_poqXvuGSHYpoWWLKEE8wm0p-uv8q8uXcVSQ3EzE3WMwrPDKa9lYDHh/exec";

let dataSoal = [];
let filteredData = [];

// BACK
function goBack(){
  window.location.href = "index.php";
}

// LOAD DATA
function loadTugas(){
  fetch(URL + "?type=tugas")
  .then(res => res.json())
  .then(data => {
    dataSoal = data || [];
    initFilterTahun();
    applyFilter();
  });
}

/* =========================
   PARSER TANGGAL (FIX UTAMA)
   format: 21/4/2026, 14.42.59
========================= */
function parseDate(dateStr){
  if(!dateStr) return {year:null, month:null};

  const parts = dateStr.split(",")[0].trim().split("/");

  if(parts.length !== 3) return {year:null, month:null};

  return {
    day: parts[0],
    month: parts[1].padStart(2,'0'),
    year: parts[2]
  };
}

// INIT TAHUN
function initFilterTahun(){
  const tahunSet = new Set();

  dataSoal.forEach(t => {
    const d = parseDate(t.date);
    if(d.year) tahunSet.add(d.year);
  });

  const select = document.getElementById("filterTahun");
  select.innerHTML = `<option value="">Semua Tahun</option>`;

  Array.from(tahunSet).sort().forEach(y => {
    select.innerHTML += `<option value="${y}">${y}</option>`;
  });
}

// FILTER
function applyFilter(){
  const tahun = document.getElementById("filterTahun").value;
  const bulan = document.getElementById("filterBulan").value;

  filteredData = dataSoal.filter(t => {

    const d = parseDate(t.date);

    if(tahun && d.year !== tahun) return false;
    if(bulan && d.month !== bulan) return false;

    return true;
  });

  renderGrid();
}

// GRID
function renderGrid(){
  const grid = document.getElementById("grid");
  grid.innerHTML = "";

  if(filteredData.length === 0){
    grid.innerHTML = "<p style='color:white'>Tidak ada data</p>";
    return;
  }

  filteredData.forEach((t,i) => {

    const sudah = t.answer && t.answer.trim() !== "";

    grid.innerHTML += `
      <div class="box" onclick="openDetail(${t.id})">
        <b>Soal #${i+1}</b><br>
        <small>${t.date}</small><br>
        <span class="status ${sudah ? 'sudah' : 'belum'}">
          ${sudah ? '✔ Sudah' : 'Belum'}
        </span>
      </div>
    `;
  });
}

// REDIRECT
function openDetail(id){
  window.location.href = "jawab_detail.php?id=" + id;
}

// INIT
loadTugas();
</script>

</body>
</html>