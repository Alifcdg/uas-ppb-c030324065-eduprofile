import 'dart:convert';

import 'package:http/http.dart' as http;

import '../models/master/angkatan_model.dart';
import '../models/master/hobby_model.dart';
import '../models/master/program_studi_model.dart';
import '../utils/constants.dart';
import 'auth_service.dart';

class MasterDataService {
  final AuthService authService = AuthService();

  Future<List<ProgramStudiModel>> getProgramStudi() async {
    final token = await authService.getToken();

    final response = await http.get(
      Uri.parse("${Constants.baseUrl}/program-studi"),
      headers: {
        "Accept": "application/json",
        "Authorization": "Bearer $token",
      },
    );

    final json = jsonDecode(response.body);

    if (response.statusCode == 200) {
      final List data = json["data"];

      return data.map((e) => ProgramStudiModel.fromJson(e)).toList();
    }

    throw Exception(json["message"]);
  }

  Future<List<AngkatanModel>> getAngkatan() async {
    final token = await authService.getToken();

    final response = await http.get(
      Uri.parse("${Constants.baseUrl}/angkatan"),
      headers: {
        "Accept": "application/json",
        "Authorization": "Bearer $token",
      },
    );

    final json = jsonDecode(response.body);

    if (response.statusCode == 200) {
      final List data = json["data"];

      return data.map((e) => AngkatanModel.fromJson(e)).toList();
    }

    throw Exception(json["message"]);
  }

  Future<List<HobbyModel>> getHobby() async {
    final token = await authService.getToken();

    final response = await http.get(
      Uri.parse("${Constants.baseUrl}/hobby"),
      headers: {
        "Accept": "application/json",
        "Authorization": "Bearer $token",
      },
    );

    final json = jsonDecode(response.body);

    if (response.statusCode == 200) {
      final List data = json["data"];

      return data.map((e) => HobbyModel.fromJson(e)).toList();
    }

    throw Exception(json["message"]);
  }
}