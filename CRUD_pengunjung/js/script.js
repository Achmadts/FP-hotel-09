function toggleNomorKartu() {
  var metode_pembayaran = document.getElementById("metode_pembayaran").value;
  var nomor_kartu_div = document.getElementById("nomor_kartu_div");
  var nomor_kartu = document.getElementById("nomor_kartu").value;
  var tgl_expired_div = document.getElementById("tgl_expired_div");

  var isNomorKartuValid = true;
  var isTanggalKadaluarsaValid = true;

  if (metode_pembayaran === "Kartu Kredit") {
    nomor_kartu_div.style.display = "block";
    tgl_expired_div.style.display = "block";

    if (nomor_kartu === "") {
      alert("Nomor Kartu Kredit wajib diisi!");
      isNomorKartuValid = false;
      return false;
    } else {
      isNomorKartuValid = true;
    }

    var tgl_expired = document.getElementById("expiry").value;
    if (tgl_expired === "") {
      alert("Tanggal Kadaluarsa wajib diisi!");
      isTanggalKadaluarsaValid = false;
      return false;
    } else {
      isTanggalKadaluarsaValid = true;
    }
  } else {
    nomor_kartu_div.style.display = "none";
    tgl_expired_div.style.display = "none";

    isNomorKartuValid = true;
    isTanggalKadaluarsaValid = true;
  }
}