// Fungsi untuk mode gelap dan mode terang
let tema_mode = document.getElementById('tema-mode');
// Jika button darkmode ada
if (tema_mode != null) {
    // Jika pada local storage telah terdapat sebuah item dengan nama tema yang isinya adalah dark
    if (localStorage.getItem('tema') === 'dark') {
        document.body.classList.toggle('dark');
        tema_mode.setAttribute('checked', 'checked');
        tema_mode.nextElementSibling.innerText = "Dark";
        // Tooggle untuk menambahkan class bernama bg-dark pada elemen dengan class card
        document.querySelectorAll('.card').forEach(index => index.classList.toggle('card-dark'));
    }
    // Ketika terdapat perubahan pada tema-mode, maka jalankan fungsi setDarkMode
    tema_mode.addEventListener('change', setDarkMode);
    // Fungsi untuk darkmode
    function setDarkMode() {
        // Jika pada local storage telah terdapat sebuah item dengan nama tema yang isinya adalah dark
        if (localStorage.getItem('tema') === 'dark') {
            // Hapus item dengan nama tema
            localStorage.removeItem('tema');
            tema_mode.nextElementSibling.innerText = "Light";
        }
        // Jika tidak ada
        else {
            // Tambahkan item bernama tema dengan isi dark
            localStorage.setItem('tema', 'dark');
            tema_mode.nextElementSibling.innerText = "Dark";
        }
        // Toggle untuk menambahkan class bernama dark pada body
        document.body.classList.toggle('dark');
        // Tooggle untuk menambahkan class bernama bg-dark pada elemen dengan class card
        document.querySelectorAll('.card').forEach(index => index.classList.toggle('card-dark'));
    }
}