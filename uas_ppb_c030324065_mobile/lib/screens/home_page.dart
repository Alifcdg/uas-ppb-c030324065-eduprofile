import 'package:flutter/material.dart';

import '../services/auth_service.dart';
import 'login_page.dart';
import 'mahasiswa/mahasiswa_page.dart';
import '../services/master_data_service.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  final authService = AuthService();
  final masterDataService = MasterDataService();

  Map<String, dynamic>? profile;
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    loadProfile();
  }

  Future<void> loadProfile() async {
    final result = await authService.getProfile();
    final prodi = await masterDataService.getProgramStudi();
final angkatan = await masterDataService.getAngkatan();
final hobby = await masterDataService.getHobby();

print(prodi.first.nama);
print(angkatan.first.tahun);
print(hobby.first.nama);

    setState(() {
      profile = result;
      isLoading = false;
    });
  }

  Future<void> doLogout() async {
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
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Dashboard"),
        actions: [
          IconButton(
            onPressed: doLogout,
            icon: const Icon(Icons.logout),
          ),
        ],
      ),
      body: isLoading
          ? const Center(
              child: CircularProgressIndicator(),
            )
          : Padding(
              padding: const EdgeInsets.all(20),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  Text(
                    profile!["user"]["name"],
                    style: const TextStyle(
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                    ),
                  ),

                  const SizedBox(height: 8),

                  Text(profile!["user"]["email"]),

                  const SizedBox(height: 4),

                  Text("Role : ${profile!["user"]["role"]}"),

                  const SizedBox(height: 30),

                  if (profile!["user"]["role"] == "Admin")
  ElevatedButton.icon(
    onPressed: () {
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (_) => const MahasiswaPage(),
        ),
      );
    },
    icon: const Icon(Icons.school),
    label: const Text("Data Mahasiswa"),
  ),

                  const SizedBox(height: 15),

                  ElevatedButton.icon(
                    onPressed: doLogout,
                    icon: const Icon(Icons.logout),
                    label: const Text("Logout"),
                  ),
                ],
              ),
            ),
    );
  }
}