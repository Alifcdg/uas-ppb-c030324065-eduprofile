class AngkatanModel {
  final int id;
  final String tahun;

  AngkatanModel({
    required this.id,
    required this.tahun,
  });

  factory AngkatanModel.fromJson(Map<String, dynamic> json) {
    return AngkatanModel(
      id: json["id"],
      tahun: json["tahun"],
    );
  }

  @override
  String toString() => tahun;
}