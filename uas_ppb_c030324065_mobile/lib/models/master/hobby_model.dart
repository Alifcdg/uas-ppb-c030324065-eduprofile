class HobbyModel {
  final int id;
  final String nama;

  HobbyModel({
    required this.id,
    required this.nama,
  });

  factory HobbyModel.fromJson(Map<String, dynamic> json) {
    return HobbyModel(
      id: json["id"],
      nama: json["nama_hobby"],
    );
  }

  @override
  String toString() => nama;
}