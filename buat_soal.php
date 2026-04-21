<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Buat Soal</title>

<style>
body {
  font-family: Arial;
  background: linear-gradient(135deg,#667eea,#764ba2);
  padding:20px;
}
.container {
  max-width:800px;
  margin:auto;
}
.card {
  background:white;
  padding:20px;
  border-radius:10px;
}
textarea {
  width:100%;
  padding:10px;
  margin-top:10px;
}
button {
  margin-top:10px;
  padding:10px;
  border:none;
  background:#667eea;
  color:white;
  border-radius:6px;
}
.back-btn {
  background:#444;
}
</style>
</head>

<body>

<div class="container">

<button class="back-btn" onclick="location.href='index.php'">⬅ Kembali</button>

<div class="card">
<h2>Tambah Soal</h2>

<textarea id="question" placeholder="Tulis soal..."></textarea>
<button onclick="addTugas()">Tambah</button>

</div>

</div>

<script>
const URL = "https://script.google.com/macros/s/AKfycbw68aPZL-ZfP_poqXvuGSHYpoWWLKEE8wm0p-uv8q8uXcVSQ3EzE3WMwrPDKa9lYDHh/exec";

function addTugas(){
  const question = document.getElementById("question").value;

  if(!question){
    alert("Soal tidak boleh kosong!");
    return;
  }

  fetch(URL,{
    method:"POST",
    headers:{
      "Content-Type":"text/plain;charset=utf-8"
    },
    body: JSON.stringify({
      type:"tugas",
      action:"create_tugas",
      question:question
    })
  })
  .then(res => res.text())
  .then(res => {
    alert("Soal berhasil ditambahkan!");
    document.getElementById("question").value = "";
  })
  .catch(err => {
    alert("Gagal kirim data!");
  });
}
</script>

</body>
</html>