import 'package:flutter/material.dart';

import '../../models/mahasiswa_model.dart';
import '../../services/mahasiswa_service.dart';

import 'detail_mahasiswa_page.dart';
import 'edit_mahasiswa_page.dart';
import 'tambah_mahasiswa_page.dart';
import '../../services/auth_service.dart';

class MahasiswaPage extends StatefulWidget {
  const MahasiswaPage({super.key});

  @override
  State<MahasiswaPage> createState() => _MahasiswaPageState();
}

class _MahasiswaPageState extends State<MahasiswaPage> {
  final MahasiswaService mahasiswaService = MahasiswaService();

  bool isLoading = true;
  List<MahasiswaModel> mahasiswaList = [];

  @override
void initState() {
  super.initState();
  checkAccess();
}

Future<void> checkAccess() async {
  final role = await AuthService().getRole();

  if (!mounted) return;

  if (role != "Admin") {
    Navigator.pop(context);

    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text("Anda tidak memiliki akses"),
      ),
    );

    return;
  }

  loadMahasiswa();
}


  Future<void> loadMahasiswa() async {
    try {
      final data = await mahasiswaService.getMahasiswa();

      setState(() {
        mahasiswaList = data;
        isLoading = false;
      });
    } catch (e) {
      setState(() {
        isLoading = false;
      });

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(e.toString()),
        ),
      );
    }
  }

  String imageUrl(String url) {
    return url.replaceFirst("127.0.0.1", "10.0.2.2");
  }

Future<void> konfirmasiHapus(MahasiswaModel mahasiswa) async {
  final hapus = await showDialog<bool>(
    context: context,
    builder: (_) => AlertDialog(
      title: const Text("Hapus Mahasiswa"),
      content: Text(
        "Yakin ingin menghapus ${mahasiswa.nama}?\n\nData yang dihapus tidak dapat dikembalikan.",
      ),
      actions: [
        TextButton(
          onPressed: () => Navigator.pop(context, false),
          child: const Text("Batal"),
        ),
        ElevatedButton(
          style: ElevatedButton.styleFrom(
            backgroundColor: Colors.red,
            foregroundColor: Colors.white,
          ),
          onPressed: () => Navigator.pop(context, true),
          child: const Text("Hapus"),
        ),
      ],
    ),
  );

  if (hapus != true) return;

  try {
    await mahasiswaService.deleteMahasiswa(mahasiswa.id);

    if (!mounted) return;

    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text("Mahasiswa berhasil dihapus"),
      ),
    );

    loadMahasiswa();
  } catch (e) {
    if (!mounted) return;

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(e.toString()),
      ),
    );
  }
}

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Data Mahasiswa"),
      ),
      body: isLoading
          ? const Center(
              child: CircularProgressIndicator(),
            )
          : mahasiswaList.isEmpty
              ? const Center(
                  child: Text("Belum ada data mahasiswa"),
                )
              : RefreshIndicator(
                  onRefresh: loadMahasiswa,
                  child: ListView.builder(
                    itemCount: mahasiswaList.length,
                    itemBuilder: (context, index) {
                      final mahasiswa = mahasiswaList[index];

                      return Card(
                        margin: const EdgeInsets.symmetric(
                          horizontal: 12,
                          vertical: 6,
                        ),
                        elevation: 3,
                        child: Padding(
                          padding: const EdgeInsets.all(12),
                          child: Column(
                            children: [
                              InkWell(
                                onTap: () {
                                  Navigator.push(
                                    context,
                                    MaterialPageRoute(
                                      builder: (_) => DetailMahasiswaPage(
                                        mahasiswa: mahasiswa,
                                      ),
                                    ),
                                  );
                                },
                                child: Row(
                                  children: [
                                    CircleAvatar(
                                      radius: 28,
                                      child: ClipOval(
                                        child: mahasiswa.foto != null
                                            ? Image.network(
                                                imageUrl(mahasiswa.foto!),
                                                width: 56,
                                                height: 56,
                                                fit: BoxFit.cover,
                                                errorBuilder: (
                                                  context,
                                                  error,
                                                  stackTrace,
                                                ) {
                                                  return const Icon(
                                                    Icons.person,
                                                  );
                                                },
                                              )
                                            : const Icon(Icons.person),
                                      ),
                                    ),

                                    const SizedBox(width: 15),

                                    Expanded(
                                      child: Column(
                                        crossAxisAlignment:
                                            CrossAxisAlignment.start,
                                        children: [
                                          Text(
                                            mahasiswa.nama,
                                            style: const TextStyle(
                                              fontWeight: FontWeight.bold,
                                              fontSize: 17,
                                            ),
                                          ),

                                          const SizedBox(height: 5),

                                          Text(mahasiswa.nim),

                                          Text(mahasiswa.programStudi),
                                        ],
                                      ),
                                    ),

                                    const Icon(
                                      Icons.chevron_right,
                                    ),
                                  ],
                                ),
                              ),

                              const SizedBox(height: 15),

                              Row(
                                mainAxisAlignment: MainAxisAlignment.end,
                                children: [
                                  OutlinedButton.icon(
                                    icon: const Icon(Icons.edit),
                                    label: const Text("Edit"),
                                    onPressed: () async {
                                      final result =
                                          await Navigator.push(
                                        context,
                                        MaterialPageRoute(
                                          builder: (_) =>
                                              EditMahasiswaPage(
                                            mahasiswa: mahasiswa,
                                          ),
                                        ),
                                      );

                                      if (result == true) {
                                        loadMahasiswa();
                                      }
                                    },
                                  ),

                                  const SizedBox(width: 10),

                                  ElevatedButton.icon(
                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: Colors.red,
                                      foregroundColor: Colors.white,
                                    ),
                                    icon: const Icon(Icons.delete),
                                    label: const Text("Hapus"),
                                    onPressed: () {
  konfirmasiHapus(mahasiswa);
},
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ),
                      );
                    },
                  ),
                ),
      floatingActionButton: FloatingActionButton(
        onPressed: () async {
          final result = await Navigator.push(
            context,
            MaterialPageRoute(
              builder: (_) => const TambahMahasiswaPage(),
            ),
          );

          if (result == true) {
            loadMahasiswa();
          }
        },
        child: const Icon(Icons.add),
      ),
    );
  }
}