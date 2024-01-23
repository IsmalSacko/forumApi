import 'package:flutter/material.dart';
import 'package:forumapp/views/widgets/input_widget.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  // initialize the controllers for the textfields (email and password)
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
          child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          const Text('Login Page'),
          const SizedBox(
            height: 30,
          ),
          InputWidget(
            hintText: 'Enter your email',
            controller: _emailController,
            obscureText: false,
          ),
          const SizedBox(
            height: 20,
          ),
          InputWidget(
            hintText: 'Enter your password',
            controller: _passwordController,
            obscureText: true,
          ),
          const SizedBox(
            height: 30,
          ),
          ElevatedButton(
            style: ElevatedButton.styleFrom(
              backgroundColor: Colors.black,
              elevation: 0,
              padding: const EdgeInsets.symmetric(horizontal: 50, vertical: 10),
            ),
            onPressed: () {},
            child: const Text('Login', style: TextStyle(color: Colors.white)),
          ),
        ],
      )),
    );
  }
}
