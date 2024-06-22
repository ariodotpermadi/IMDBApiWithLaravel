# IMDBApiWithLaravel
Penjelasan Kode
getPopularMovies Method:

Menggunakan query umum 's' => 'a' untuk mendapatkan daftar film. Huruf 'a' dipilih karena cenderung muncul di banyak judul film.
Tetap menyertakan parameter type sebagai movie, y sebagai tahun rilis, dan r sebagai format respons JSON.

Di dalam controller terdapat method callIMDBApi :

Untuk menangani caching dan pemanggilan API

Endpoint
Menampilkan film terpopuler berdasarkan tahun:
GET http://localhost:8000/api/movie/popular?year=2024

Menampilkan detail informasi film berdasarkan ID:
GET
http://localhost:8000/api/movie/detail?id=tt3896198

Menampilkan Informasi Detail Informasi Film Berdasarkan paramater :
GET
http://localhost:8000/api/movie/search?query=tom%20cruise

NB : 
- Modul laravel berada di branch Master.
- Sepertinya ada perubahan paramater dari IMDB untuk popular movie.






![by searching](https://github.com/ariodotpermadi/IMDBApiWithLaravel/assets/48463485/5499d594-8cf7-424a-818b-d364e9d71d3b)
![Detail Movie](https://github.com/ariodotpermadi/IMDBApiWithLaravel/assets/48463485/7db63cc4-5778-4b07-a45d-0e2e426d82c4)


