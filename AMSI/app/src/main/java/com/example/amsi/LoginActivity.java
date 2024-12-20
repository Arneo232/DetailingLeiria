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

public class LoginActivity extends AppCompatActivity {

    public static final int MIN_PASS=4;
    public static final String EMAIL= "Email";

    public EditText etEmail, etPassword;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        etEmail = findViewById(R.id.etEmail);
        etPassword = findViewById(R.id.etPassword);
    }

    public void onClickLogin(View view) {
        String email = etEmail.getText().toString();
        String pass= etPassword.getText().toString();

        if(!isEmailValido(email)){
            etEmail.setError("Formato de email inválido");
            return;
        }
        if(!isPasswordValida(pass)){
            etPassword.setError("Sem car. necessários");
            return;
        }
        //Toast.makeText(this, "Login efetuado com sucesso", Toast.LENGTH_LONG).show();
        // Intent intent = new Intent(this, MainActivity.class);
        Intent intent = new Intent(this, MenuMainActivity.class);
        intent.putExtra(EMAIL, email);
        startActivity(intent);
        finish();
    }

    public boolean isEmailValido(String email){
        if(email==null)
            return false;
        return Patterns.EMAIL_ADDRESS.matcher(email).matches();
    }

    public boolean isPasswordValida(String pass){
        if(pass==null)
            return false;
        return pass.length()>=MIN_PASS;
    }
}