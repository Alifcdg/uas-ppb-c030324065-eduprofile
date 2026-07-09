import 'dart:convert';
import 'dart:io';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

import '../models/mahasiswa_model.dart';
import '../services/auth_service.dart';
import 'login_page.dart';

class ProfilePage extends StatefulWidget {
  const ProfilePage({super.key});

  @override
  State<ProfilePage> createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  final AuthService authService = AuthService();

  final namaController = TextEditingController();
  final emailController = TextEditingController();
  final alamatController = TextEditingController();
  final noHpController = TextEditingController();

  MahasiswaModel? profile;

  File? selectedImage;

  bool isLoading = true;
  bool isSaving = false;

  @override
  void initState() {
    super.initState();
    loadProfile();
  }

  String imageUrl(String url) {
    return url.replaceFirst("127.0.0.1", "10.0.2.2");
  }

  Future<void> loadProfile() async {
    try {
      profile = await authService.getMyProfile();

      namaController.text = profile!.nama;
      emailController.text = profile!.email;
      alamatController.text = profile!.alamat;
      noHpController.text = profile!.noHp;

      setState(() {
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

  Future<void> pickImage() async {
    final picker = ImagePicker();

    final image = await picker.pickImage(
      source: ImageSource.gallery,
      imageQuality: 80,
    );

    if (image == null) return;

    setState(() {
      selectedImage = File(image.path);
    });
  }

  Future<void> saveProfile() async {
    setState(() {
      isSaving = true;
    });

    try {
      final result = await authService.updateMyProfile(
        nama: namaController.text,
        email: emailController.text,
        alamat: alamatController.text,
        noHp: noHpController.text,
        foto: selectedImage,
      );

      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(result["message"]),
        ),
      );

      await loadProfile();
    } catch (e) {
      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(e.toString()),
        ),
      );
    }

    setState(() {
      isSaving = false;
    });
  }

  Future<void> logout() async {
    await authService.logout();

    if (!mounted) return;

    Navigator.pushAndRemoveUntil(
      context,
      MaterialPageRoute(
        builder: (_) => const LoginPage(),
      ),
      (route) => false,
    );
  }

  @override
  void dispose() {
    namaController.dispose();
    emailController.dispose();
    alamatController.dispose();
    noHpController.dispose();

    super.dispose();
  }
    @override
  Widget build(BuildContext context) {
    if (isLoading) {
      return const Scaffold(
        body: Center(
          child: CircularProgressIndicator(),
        ),
      );
    }

    return Scaffold(
      appBar: AppBar(
        title: const Text("Profil Saya"),
        actions: [
          IconButton(
            onPressed: logout,
            icon: const Icon(Icons.logout),
          ),
        ],
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20),
        child: Column(
          children: [

            GestureDetector(
              onTap: pickImage,
              child: CircleAvatar(
                radius: 60,
                backgroundColor: Colors.grey.shade300,
                backgroundImage: selectedImage != null
                    ? FileImage(selectedImage!)
                    : (profile!.foto != null
                        ? NetworkImage(
                            imageUrl(profile!.foto!),
                          ) as ImageProvider
                        : null),
                child: selectedImage == null && profile!.foto == null
                    ? const Icon(
                        Icons.person,
                        size: 55,
                      )
                    : null,
              ),
            ),

            const SizedBox(height: 10),

            const Text(
              "Tap foto untuk mengganti",
              style: TextStyle(
                color: Colors.grey,
              ),
            ),

            const SizedBox(height: 30),

            TextField(
              controller: namaController,
              decoration: const InputDecoration(
                labelText: "Nama",
                prefixIcon: Icon(Icons.person),
                border: OutlineInputBorder(),
              ),
            ),

            const SizedBox(height: 15),

            TextField(
              controller: emailController,
              decoration: const InputDecoration(
                labelText: "Email",
                prefixIcon: Icon(Icons.email),
                border: OutlineInputBorder(),
              ),
            ),

            const SizedBox(height: 15),

            TextField(
              controller: alamatController,
              maxLines: 3,
              decoration: const InputDecoration(
                labelText: "Alamat",
                prefixIcon: Icon(Icons.home),
                border: OutlineInputBorder(),
              ),
            ),

            const SizedBox(height: 15),

            TextField(
              controller: noHpController,
              decoration: const InputDecoration(
                labelText: "No HP",
                prefixIcon: Icon(Icons.phone),
                border: OutlineInputBorder(),
              ),
            ),

            const SizedBox(height: 25),

            Card(
              elevation: 2,
              child: Padding(
                padding: const EdgeInsets.all(16),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [

                    const Text(
                      "Informasi Akademik",
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                        fontSize: 16,
                      ),
                    ),

                    const Divider(),

                    ListTile(
                      leading: const Icon(Icons.badge),
                      title: const Text("NIM"),
                      subtitle: Text(profile!.nim),
                    ),

                    ListTile(
                      leading: const Icon(Icons.school),
                      title: const Text("Program Studi"),
                      subtitle: Text(profile!.programStudi),
                    ),

                    ListTile(
                      leading: const Icon(Icons.calendar_today),
                      title: const Text("Angkatan"),
                      subtitle: Text(profile!.angkatan),
                    ),

                    ListTile(
                      leading: const Icon(Icons.favorite),
                      title: const Text("Hobby"),
                      subtitle: Text(profile!.hobby),
                    ),

                  ],
                ),
              ),
            ),

            const SizedBox(height: 30),

            SizedBox(
              width: double.infinity,
              height: 55,
              child: ElevatedButton.icon(
                onPressed: isSaving ? null : saveProfile,
                icon: isSaving
                    ? const SizedBox(
                        width: 18,
                        height: 18,
                        child: CircularProgressIndicator(
                          strokeWidth: 2,
                          color: Colors.white,
                        ),
                      )
                    : const Icon(Icons.save),
                label: Text(
                  isSaving
                      ? "Menyimpan..."
                      : "Simpan Perubahan",
                ),
              ),
            ),

            const SizedBox(height: 15),

            SizedBox(
              width: double.infinity,
              height: 55,
              child: OutlinedButton.icon(
                onPressed: logout,
                icon: const Icon(Icons.logout),
                label: const Text("Logout"),
              ),
            ),

          ],
        ),
      ),
    );
  }
}