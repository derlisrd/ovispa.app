import 'package:flutter/material.dart';


class AuthProvider extends ChangeNotifier {
  bool _isAuth = false;

  bool get isAuth => _isAuth;

  void login() {
    // Aquí implementa la lógica de inicio de sesión.
    _isAuth = true;
    notifyListeners();
  }

  void logout() {
    // Aquí implementa la lógica de cierre de sesión.
    _isAuth = false;
    notifyListeners();
  }
}