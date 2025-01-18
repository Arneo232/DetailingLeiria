package com.example.amsi;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.amsi.listeners.RegisterListener;
import com.example.amsi.modelo.SingletonGestorProdutos;
import com.example.amsi.modelo.Utilizador;

public class RegisterActivity extends AppCompatActivity implements RegisterListener {

    public EditText etEmail, etUsername, etPassword, etMorada, etTelefone;
    public Utilizador utilizador;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        setTitle("Register");
        etEmail = findViewById(R.id.etEmail);
        etUsername = findViewById(R.id.etUsername);
        etPassword = findViewById(R.id.etPassword);
        etMorada = findViewById(R.id.etMorada);
        etTelefone = findViewById(R.id.etTelefone);
    }

    public void onClickRegister(View view) {
        String email = etEmail.getText().toString();
        String username = etUsername.getText().toString();
        String password = etPassword.getText().toString();
        String morada = etMorada.getText().toString();
        String telefone = etTelefone.getText().toString();


        Utilizador utilizador = new Utilizador(0, 0, username, email, password, telefone, morada, "0");

        SingletonGestorProdutos singletonGestorProdutos = SingletonGestorProdutos.getInstance(this);
        singletonGestorProdutos.setRegisterListener(this);
        singletonGestorProdutos.registerAPI(utilizador, getApplicationContext());
    }



    @Override
    public void onSignup(String message) {
        Toast.makeText(this, "Registo feito! Faça login!", Toast.LENGTH_SHORT).show();
        Intent intent = new Intent(this, LoginActivity.class);
        startActivity(intent);
        finish();
    }
}