import 'package:flutter/material.dart';
import 'package:ovispaapp/src/models/login_response.dart';
import 'package:ovispaapp/src/services/apicaller.dart';


class AuthProvider extends ChangeNotifier {
  bool _isAuth = true;

  bool get isAuth => _isAuth;

   Future<dynamic> login(String email,String pass) async{
    final LoginResponse response = await ApiCaller().login(email,pass);
    if(response.success){

    _isAuth = true;
    notifyListeners();
    }
  }



  void logout() {
    // Aquí implementa la lógica de cierre de sesión.
    _isAuth = false;
    notifyListeners();
  }
}