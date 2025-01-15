package com.example.amsi;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;

import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.example.amsi.listeners.LoginListener;
import com.example.amsi.modelo.SingletonGestorProdutos;

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
        String user = etUsername.getText().toString();
        String pass = etPassword.getText().toString();

        if (!isPasswordValida(pass)) {
            etPassword.setError("Password inválida");
            return;
        }

        SingletonGestorProdutos singletonGestorProdutos = SingletonGestorProdutos.getInstance(this);
        singletonGestorProdutos.setLoginListener(this);

        singletonGestorProdutos.loginAPI(user, pass, getApplicationContext());
    }

    private boolean isPasswordValida(String password) {
        return password != null && password.length() >= MIN_PASS;
    }

    @Override
    public void onValidateLogin(final Context context, final String auth_key, final String username, final String email, final int profileId) {
        // Handle successful login
        Toast.makeText(context, "Login efetuado com sucesso! Bem-vindo, " + username, Toast.LENGTH_SHORT).show();

        Intent intent = new Intent(LoginActivity.this, AboutUsActivity.class);
        intent.putExtra("AUTH_KEY", auth_key);
        intent.putExtra("USERNAME", username);
        intent.putExtra("EMAIL", email);
        intent.putExtra("PROFILE_ID", profileId);
        startActivity(intent);

        finish();
    }
}
