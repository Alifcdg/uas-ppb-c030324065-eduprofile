import 'dart:io';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

import '../../models/master/angkatan_model.dart';
import '../../models/master/hobby_model.dart';
import '../../models/master/program_studi_model.dart';

import '../../services/master_data_service.dart';
import '../../services/mahasiswa_service.dart';

import '../../widgets/dropdown_input.dart';
import '../../widgets/text_input.dart';

class TambahMahasiswaPage extends StatefulWidget {
  const TambahMahasiswaPage({super.key});

  @override
  State<TambahMahasiswaPage> createState() =>
      _TambahMahasiswaPageState();
}

class _TambahMahasiswaPageState
    extends State<TambahMahasiswaPage> {

  final _formKey = GlobalKey<FormState>();

  final masterDataService = MasterDataService();
  final mahasiswaService = MahasiswaService();

  final namaController = TextEditingController();
  final emailController = TextEditingController();
  final nimController = TextEditingController();
  final tanggalController = TextEditingController();
  final alamatController = TextEditingController();
  final noHpController = TextEditingController();

  List<ProgramStudiModel> programStudi = [];
  List<AngkatanModel> angkatan = [];
  List<HobbyModel> hobby = [];

  ProgramStudiModel? selectedProgramStudi;
  AngkatanModel? selectedAngkatan;
  HobbyModel? selectedHobby;

  String jenisKelamin = "Laki-laki";

  File? selectedImage;

  bool isLoading = true;
  bool isSaving = false;

  @override
  void initState() {
    super.initState();
    loadMasterData();
  }

  Future<void> loadMasterData() async {
    final prodi = await masterDataService.getProgramStudi();
    final angkatanData = await masterDataService.getAngkatan();
    final hobbyData = await masterDataService.getHobby();

    setState(() {
      programStudi = prodi;
      angkatan = angkatanData;
      hobby = hobbyData;

      selectedProgramStudi = prodi.first;
      selectedAngkatan = angkatanData.first;
      selectedHobby = hobbyData.first;

      isLoading = false;
    });
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

  Future<void> pickDate() async {
    final date = await showDatePicker(
      context: context,
      firstDate: DateTime(1990),
      lastDate: DateTime.now(),
      initialDate: DateTime(2005),
    );

    if (date == null) return;

    tanggalController.text =
        "${date.year}-${date.month.toString().padLeft(2, '0')}-${date.day.toString().padLeft(2, '0')}";
  }

  Future<void> saveMahasiswa() async {
  if (!_formKey.currentState!.validate()) return;

  setState(() {
    isSaving = true;
  });

  try {
    await mahasiswaService.storeMahasiswa(
      nama: namaController.text.trim(),
      email: emailController.text.trim(),
      nim: nimController.text.trim(),
      tanggalLahir: tanggalController.text.trim(),
      jenisKelamin: jenisKelamin,
      alamat: alamatController.text.trim(),
      noHp: noHpController.text.trim(),
      programStudiId: selectedProgramStudi!.id,
      angkatanId: selectedAngkatan!.id,
      hobbyId: selectedHobby!.id,
      foto: selectedImage,
    );

    if (!mounted) return;

    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text("Mahasiswa berhasil ditambahkan"),
      ),
    );

    Navigator.pop(context, true);
  } catch (e) {
    if (!mounted) return;

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(e.toString()),
      ),
    );
  } finally {
    if (mounted) {
      setState(() {
        isSaving = false;
      });
    }
  }
}

  @override
  void dispose() {
    namaController.dispose();
    emailController.dispose();
    nimController.dispose();
    tanggalController.dispose();
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
        title: const Text("Tambah Mahasiswa"),
      ),
      body: Form(
        key: _formKey,
        child: ListView(
          padding: const EdgeInsets.all(20),
          children: [
            GestureDetector(
  onTap: pickImage,
  child: Center(
    child: CircleAvatar(
      radius: 55,
      backgroundColor: Colors.grey.shade300,
      backgroundImage:
          selectedImage != null ? FileImage(selectedImage!) : null,
      child: selectedImage == null
          ? const Icon(
              Icons.camera_alt,
              size: 40,
            )
          : null,
    ),
  ),
),

const SizedBox(height: 12),

const Center(
  child: Text(
    "Tap untuk memilih foto",
    style: TextStyle(color: Colors.grey),
  ),
),

const SizedBox(height: 25),

TextInput(
  controller: namaController,
  label: "Nama",
  icon: Icons.person,
),

TextInput(
  controller: emailController,
  label: "Email",
  icon: Icons.email,
  keyboardType: TextInputType.emailAddress,
),

TextInput(
  controller: nimController,
  label: "NIM",
  icon: Icons.badge,
),

TextInput(
  controller: tanggalController,
  label: "Tanggal Lahir",
  icon: Icons.calendar_month,
  readOnly: true,
  onTap: pickDate,
),

Padding(
  padding: const EdgeInsets.only(bottom: 15),
  child: DropdownButtonFormField<String>(
    value: jenisKelamin,
    decoration: InputDecoration(
      labelText: "Jenis Kelamin",
      prefixIcon: const Icon(Icons.people),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
      ),
    ),
    items: const [
      DropdownMenuItem(
        value: "Laki-laki",
        child: Text("Laki-laki"),
      ),
      DropdownMenuItem(
        value: "Perempuan",
        child: Text("Perempuan"),
      ),
    ],
    onChanged: (value) {
      setState(() {
        jenisKelamin = value!;
      });
    },
  ),
),

DropdownInput<ProgramStudiModel>(
  label: "Program Studi",
  value: selectedProgramStudi,
  items: programStudi,
  itemLabel: (e) => e.nama,
  onChanged: (value) {
    setState(() {
      selectedProgramStudi = value;
    });
  },
  icon: Icons.school,
),

DropdownInput<AngkatanModel>(
  label: "Angkatan",
  value: selectedAngkatan,
  items: angkatan,
  itemLabel: (e) => e.tahun,
  onChanged: (value) {
    setState(() {
      selectedAngkatan = value;
    });
  },
  icon: Icons.calendar_today,
),

DropdownInput<HobbyModel>(
  label: "Hobby",
  value: selectedHobby,
  items: hobby,
  itemLabel: (e) => e.nama,
  onChanged: (value) {
    setState(() {
      selectedHobby = value;
    });
  },
  icon: Icons.favorite,
),

TextInput(
  controller: alamatController,
  label: "Alamat",
  icon: Icons.home,
  maxLines: 3,
),

TextInput(
  controller: noHpController,
  label: "No HP",
  icon: Icons.phone,
  keyboardType: TextInputType.phone,
),

const SizedBox(height: 10),

SizedBox(
  height: 55,
  child: ElevatedButton.icon(
    onPressed: isSaving ? null : saveMahasiswa,
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
      isSaving ? "Menyimpan..." : "Simpan Mahasiswa",
      style: const TextStyle(fontSize: 16),
    ),
  ),
),
          ]
        ),
      ),
    );
  }
}