import 'package:flutter/material.dart';
import 'package:ovispaapp/src/widgets/Fonts/montsetext.dart';

class RegisterScreen extends StatefulWidget {
  static const String routeName = '/register';
  const RegisterScreen({super.key});

  @override
  State<RegisterScreen> createState() => _RegisterScreenState();
}

class _RegisterScreenState extends State<RegisterScreen> {
  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      appBar: AppBar(),
      body: const SafeArea(
        child: SafeArea(child: 
        Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              MontseText(texto: 'Registro',style: TextStyle(fontSize: 44, fontWeight: FontWeight.bold))
            ],
          ),
        )
      ), 
      ),
    );
  }
}