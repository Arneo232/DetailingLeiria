package com.example.amsi;

import android.content.Intent;
import android.os.Bundle;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;

import android.os.Bundle;
import android.util.Patterns;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.amsi.listeners.LoginListener;
import com.example.amsi.modelo.SingletonGestorProdutos;
import com.example.amsi.modelo.Utilizador;

public class LoginActivity extends AppCompatActivity implements LoginListener {

    public static final int MIN_PASS=4;
    public static final String USERNAME = "username";
    public static final String PASSWORD = "password";
    public static final String TOKEN = "token";

    public EditText etUsername, etPassword;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        setTitle("Login");

        etUsername = findViewById(R.id.etUsername);
        etPassword = findViewById(R.id.etPassword);

        SingletonGestorProdutos.getInstance(this).setLoginListener(this);
    }

    private boolean isUsernameValido(String username) {
        if (username == null) {
            return false;
        }

        // Define your username validation pattern
        String usernamePattern = "^[a-zA-Z0-9_]{3,20}$";

        return username.matches(usernamePattern);
    }

    private boolean isPasswordValida(String password){
        if(password==null)
            return false;

        return password.length()>=MIN_PASS;
    }

    @Override
    public void onUpdateLogin(Utilizador utilizador) {
        if(utilizador.getAuth_key() != null) {
            Intent intent = new Intent(this, MenuMainActivity.class);
            intent.putExtra(TOKEN, utilizador.getAuth_key());
            intent.putExtra(USERNAME, utilizador.getUsername());

            startActivity(intent);
            //finish();
        }
        else {
            Toast.makeText(this, "Token incorreto", Toast.LENGTH_SHORT).show();
        }
    }
}