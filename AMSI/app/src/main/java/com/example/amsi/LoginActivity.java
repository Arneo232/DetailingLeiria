package com.example.amsi;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;

import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.example.amsi.listeners.LoginListener;
import com.example.amsi.modelo.SingletonGestorProdutos;
import com.example.amsi.modelo.Utilizador;

import android.content.SharedPreferences;

public class LoginActivity extends AppCompatActivity implements LoginListener {

    public static final int MIN_PASS = 4;
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
    }

    public void onClickLogin(View view) {
        String username = etUsername.getText().toString();
        String password = etPassword.getText().toString();

        if (!isPasswordValida(password)) {
            etPassword.setError("Password inválida");
            return;
        }

        SingletonGestorProdutos singletonGestorProdutos = SingletonGestorProdutos.getInstance(this);
        singletonGestorProdutos.setLoginListener(this);

        singletonGestorProdutos.loginAPI(username, password, getApplicationContext());
    }

    public void onClickGoReg(View view){
        Intent intent = new Intent(this, RegisterActivity.class);
        startActivity(intent);
        finish();
    }

    private boolean isPasswordValida(String password) {
        return password != null && password.length() >= MIN_PASS;
    }

    @Override
    public void onValidateLogin(final Context context, final Utilizador utilizador) {
        if (utilizador.token != null) {
            // Armazenar os dados do utilizador nas SharedPreferences
            SharedPreferences sharedPreferences = getSharedPreferences("UserPreferences", Context.MODE_PRIVATE);
            SharedPreferences.Editor editor = sharedPreferences.edit();
            editor.putString("email", utilizador.getEmail());
            editor.putString("nome", utilizador.getUsername());
            editor.putString("telefone", utilizador.getNtelefone());
            editor.putString("morada", utilizador.getMorada());
            editor.apply();

            Toast.makeText(context, "Login efetuado com sucesso! Bem-vindo, " + utilizador.getUsername(), Toast.LENGTH_SHORT).show();

            Intent intent = new Intent(this, MenuMainActivity.class);
            intent.putExtra(USERNAME, utilizador.getUsername());
            intent.putExtra(TOKEN, utilizador.getToken());
            startActivity(intent);
            finish();
        } else {
            Toast.makeText(this, "Token incorreto", Toast.LENGTH_SHORT).show();
        }
    }
}
