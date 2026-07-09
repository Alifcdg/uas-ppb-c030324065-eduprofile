import 'dart:convert';
import 'dart:io';

import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

import '../models/mahasiswa_model.dart';
import '../utils/constants.dart';

class AuthService {
  Future<Map<String, dynamic>> login(
    String email,
    String password,
  ) async {
    final response = await http.post(
      Uri.parse("${Constants.baseUrl}/login"),
      headers: {
        "Accept": "application/json",
      },
      body: {
        "email": email,
        "password": password,
      },
    );

    return jsonDecode(response.body);
  }

  Future<void> saveToken(String token) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString("token", token);
  }

  Future<void> saveRole(String role) async {
  final prefs = await SharedPreferences.getInstance();
  await prefs.setString("role", role);
}

Future<String?> getRole() async {
  final prefs = await SharedPreferences.getInstance();
  return prefs.getString("role");
}

  Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString("token");
  }

  Future<Map<String, dynamic>> getProfile() async {
    final token = await getToken();

    final response = await http.get(
      Uri.parse("${Constants.baseUrl}/profile"),
      headers: {
        "Accept": "application/json",
        "Authorization": "Bearer $token",
      },
    );

    return jsonDecode(response.body);
  }

  Future<MahasiswaModel> getMyProfile() async {
  final token = await getToken();

  final response = await http.get(
    Uri.parse("${Constants.baseUrl}/my-profile"),
    headers: {
      "Accept": "application/json",
      "Authorization": "Bearer $token",
    },
  );

  final json = jsonDecode(response.body);

  return MahasiswaModel.fromJson(json["data"]);
}

  Future<void> logout() async {
  final token = await getToken();

  await http.post(
    Uri.parse("${Constants.baseUrl}/logout"),
    headers: {
      "Accept": "application/json",
      "Authorization": "Bearer $token",
    },
  );

  final prefs = await SharedPreferences.getInstance();

  await prefs.remove("token");
  await prefs.remove("role");
}

Future<Map<String, dynamic>> updateMyProfile({
  required String nama,
  required String email,
  required String alamat,
  required String noHp,
  File? foto,
}) async {
  final token = await getToken();

  var request = http.MultipartRequest(
    "POST",
    Uri.parse("${Constants.baseUrl}/my-profile"),
  );

  request.headers["Authorization"] = "Bearer $token";
  request.headers["Accept"] = "application/json";

  request.fields["nama"] = nama;
  request.fields["email"] = email;
  request.fields["alamat"] = alamat;
  request.fields["no_hp"] = noHp;

  if (foto != null) {
    request.files.add(
      await http.MultipartFile.fromPath(
        "foto",
        foto.path,
      ),
    );
  }

  final streamed = await request.send();

  final response = await http.Response.fromStream(streamed);

  return jsonDecode(response.body);
}
}