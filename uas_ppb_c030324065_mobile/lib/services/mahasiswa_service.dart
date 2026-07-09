import 'dart:convert';
import 'dart:io';

import 'package:http/http.dart' as http;

import '../models/mahasiswa_model.dart';
import '../utils/constants.dart';
import 'auth_service.dart';

class MahasiswaService {
  final AuthService authService = AuthService();

  Future<List<MahasiswaModel>> getMahasiswa() async {
    final token = await authService.getToken();

    final response = await http.get(
      Uri.parse("${Constants.baseUrl}/mahasiswa"),
      headers: {
        "Accept": "application/json",
        "Authorization": "Bearer $token",
      },
    );

    final json = jsonDecode(response.body);

    if (response.statusCode == 200) {
      final List data = json["data"];

      return data.map((e) => MahasiswaModel.fromJson(e)).toList();
    } else {
      throw Exception(json["message"]);
    }
  }

  Future<void> updateMahasiswa({
  required int id,
  required String nama,
  required String email,
  required String nim,
  required String tanggalLahir,
  required String jenisKelamin,
  required String alamat,
  required String noHp,
  required int programStudiId,
  required int angkatanId,
  required int hobbyId,
  File? foto,
}) async {
  final token = await authService.getToken();

  final request = http.MultipartRequest(
    "POST",
    Uri.parse("${Constants.baseUrl}/mahasiswa/$id"),
  );

  request.headers["Authorization"] = "Bearer $token";
  request.headers["Accept"] = "application/json";

  // Laravel menerima update multipart dengan method spoofing
  request.fields["_method"] = "PUT";

  request.fields["nama"] = nama;
  request.fields["email"] = email;
  request.fields["nim"] = nim;
  request.fields["tanggal_lahir"] = tanggalLahir;
  request.fields["jenis_kelamin"] = jenisKelamin;
  request.fields["alamat"] = alamat;
  request.fields["no_hp"] = noHp;
  request.fields["program_studi_id"] = programStudiId.toString();
  request.fields["angkatan_id"] = angkatanId.toString();
  request.fields["hobby_id"] = hobbyId.toString();

  if (foto != null) {
    request.files.add(
      await http.MultipartFile.fromPath(
        "foto",
        foto.path,
      ),
    );
  }

  final response = await request.send();

  final body = await response.stream.bytesToString();
  final json = jsonDecode(body);

  if (response.statusCode != 200) {
    throw Exception(json["message"]);
  }
}

Future<void> deleteMahasiswa(int id) async {
  final token = await authService.getToken();

  final response = await http.delete(
    Uri.parse("${Constants.baseUrl}/mahasiswa/$id"),
    headers: {
      "Accept": "application/json",
      "Authorization": "Bearer $token",
    },
  );

  final json = jsonDecode(response.body);

  if (response.statusCode != 200) {
    throw Exception(json["message"]);
  }
}

  Future<void> storeMahasiswa({
    required String nama,
    required String email,
    required String nim,
    required String tanggalLahir,
    required String jenisKelamin,
    required String alamat,
    required String noHp,
    required int programStudiId,
    required int angkatanId,
    required int hobbyId,
    File? foto,
  }) async {
    final token = await authService.getToken();

    var request = http.MultipartRequest(
      "POST",
      Uri.parse("${Constants.baseUrl}/mahasiswa"),
    );

    request.headers["Authorization"] = "Bearer $token";
    request.headers["Accept"] = "application/json";

    request.fields["nama"] = nama;
    request.fields["email"] = email;
    request.fields["nim"] = nim;
    request.fields["tanggal_lahir"] = tanggalLahir;
    request.fields["jenis_kelamin"] = jenisKelamin;
    request.fields["alamat"] = alamat;
    request.fields["no_hp"] = noHp;
    request.fields["program_studi_id"] = programStudiId.toString();
    request.fields["angkatan_id"] = angkatanId.toString();
    request.fields["hobby_id"] = hobbyId.toString();

    if (foto != null) {
      request.files.add(
        await http.MultipartFile.fromPath(
          "foto",
          foto.path,
        ),
      );
    }

    final streamedResponse = await request.send();

    final response = await http.Response.fromStream(streamedResponse);

    final json = jsonDecode(response.body);

    if (response.statusCode != 201) {
      throw Exception(json["message"]);
    }
  }
}