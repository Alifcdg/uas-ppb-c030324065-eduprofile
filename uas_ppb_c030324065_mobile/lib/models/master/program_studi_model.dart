class ProgramStudiModel {
  final int id;
  final String nama;

  ProgramStudiModel({
    required this.id,
    required this.nama,
  });

  factory ProgramStudiModel.fromJson(Map<String, dynamic> json) {
    return ProgramStudiModel(
      id: json["id"],
      nama: json["nama_program_studi"],
    );
  }

  @override
  String toString() => nama;
}