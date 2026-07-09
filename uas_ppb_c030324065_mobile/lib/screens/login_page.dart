import 'package:flutter/material.dart';
import '../services/auth_service.dart';
import 'home_page.dart';
import 'profile_page.dart';
class LoginPage extends StatefulWidget {

  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();

}

class _LoginPageState extends State<LoginPage> {

  final emailController = TextEditingController();

  final passwordController = TextEditingController();

  final authService = AuthService();

  @override
  Widget build(BuildContext context) {

    return Scaffold(

      appBar: AppBar(
        title: const Text("Login"),
      ),

      body: Padding(

        padding: const EdgeInsets.all(20),

        child: Column(

          children: [

            TextField(
              controller: emailController,
              decoration: const InputDecoration(
                labelText: "Email",
              ),
            ),

            const SizedBox(height: 15),

            TextField(
              controller: passwordController,
              obscureText: true,
              decoration: const InputDecoration(
                labelText: "Password",
              ),
            ),

            const SizedBox(height: 25),

            ElevatedButton(
  onPressed: () async {

    final result = await authService.login(
      emailController.text,
      passwordController.text,
    );

    if (result["success"] == true) {

  await authService.saveToken(result["token"]);
  await authService.saveRole(result["user"]["role"]);

  if (!mounted) return;

  if (result["user"]["role"] == "Admin") {

    Navigator.pushReplacement(
      context,
      MaterialPageRoute(
        builder: (_) => const HomePage(),
      ),
    );

  } else {

    Navigator.pushReplacement(
      context,
      MaterialPageRoute(
        builder: (_) => const ProfilePage(),
      ),
    );

  }

} else {

  ScaffoldMessenger.of(context).showSnackBar(
    SnackBar(
      content: Text(result["message"]),
    ),
  );

}

  },
  child: const Text("LOGIN"),
)

          ],

        ),

      ),

    );

  }

}