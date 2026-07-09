import 'package:flutter/material.dart';

import '../../models/mahasiswa_model.dart';

class DetailMahasiswaPage extends StatelessWidget {
  final MahasiswaModel mahasiswa;

  const DetailMahasiswaPage({
    super.key,
    required this.mahasiswa,
  });

  @override
  Widget build(BuildContext context) {
    String imageUrl(String url) {
      return url.replaceFirst("127.0.0.1", "10.0.2.2");
    }

    return Scaffold(
      appBar: AppBar(
        title: const Text("Detail Mahasiswa"),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20),
        child: Column(
          children: [

            CircleAvatar(
              radius: 60,
              backgroundImage: mahasiswa.foto != null
                  ? NetworkImage(imageUrl(mahasiswa.foto!))
                  : null,
              child: mahasiswa.foto == null
                  ? const Icon(Icons.person, size: 60)
                  : null,
            ),

            const SizedBox(height: 20),

            Text(
              mahasiswa.nama,
              style: const TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
              ),
            ),

            const SizedBox(height: 30),

            infoTile("NIM", mahasiswa.nim),
            infoTile("Email", mahasiswa.email),
            infoTile("Jenis Kelamin", mahasiswa.jenisKelamin),
            infoTile("Tanggal Lahir", mahasiswa.tanggalLahir),
            infoTile("Alamat", mahasiswa.alamat),
            infoTile("No HP", mahasiswa.noHp),
            infoTile("Program Studi", mahasiswa.programStudi),
            infoTile("Angkatan", mahasiswa.angkatan),
            infoTile("Hobby", mahasiswa.hobby),
          ],
        ),
      ),
    );
  }

  Widget infoTile(String title, String value) {
    return Card(
      child: ListTile(
        title: Text(title),
        subtitle: Text(value),
      ),
    );
  }
}