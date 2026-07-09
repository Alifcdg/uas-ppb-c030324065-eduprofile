class MahasiswaModel {
  final int id;

  final String nama;
  final String email;
  final String nim;

  final String tanggalLahir;
  final String jenisKelamin;
  final String alamat;
  final String noHp;

  final String? foto;

  final int programStudiId;
  final String programStudi;

  final int angkatanId;
  final String angkatan;

  final int hobbyId;
  final String hobby;

  MahasiswaModel({
    required this.id,
    required this.nama,
    required this.email,
    required this.nim,
    required this.tanggalLahir,
    required this.jenisKelamin,
    required this.alamat,
    required this.noHp,
    required this.foto,
    required this.programStudiId,
    required this.programStudi,
    required this.angkatanId,
    required this.angkatan,
    required this.hobbyId,
    required this.hobby,
  });

  factory MahasiswaModel.fromJson(Map<String, dynamic> json) {
    return MahasiswaModel(
      id: json["id"],
      nama: json["nama"],
      email: json["email"],
      nim: json["nim"],
      tanggalLahir: json["tanggal_lahir"],
      jenisKelamin: json["jenis_kelamin"],
      alamat: json["alamat"],
      noHp: json["no_hp"],
      foto: json["foto"],

      programStudiId: json["program_studi"]["id"],
      programStudi: json["program_studi"]["nama_program_studi"],

      angkatanId: json["angkatan"]["id"],
      angkatan: json["angkatan"]["tahun"],

      hobbyId: json["hobby"]["id"],
      hobby: json["hobby"]["nama_hobby"],
    );
  }
}