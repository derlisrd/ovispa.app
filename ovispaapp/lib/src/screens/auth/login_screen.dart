import 'package:flutter/material.dart';
import 'package:ovispaapp/src/widgets/Fonts/montsetext.dart';
import 'package:ovispaapp/src/widgets/buttons/primary_button.dart';
import 'package:ovispaapp/src/widgets/textfields/inputtext.dart';

class LoginScreen extends StatefulWidget {


  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final emailController = TextEditingController();
  final passController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      body: SafeArea(child: 
        Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
             const MontseText(texto: 'Bienvenid@ !',style: TextStyle(fontSize: 24)),
              InputText(controller: emailController, hintText: 'Email'),
              InputText(controller: passController, hintText: 'Contraseña', obscureText: true,),
              const PrimaryButton()
            ],
          ),
        )
      ),
    );
  }
}