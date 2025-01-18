package com.example.amsi;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class PerfilActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_perfil);

        // Recuperar os dados armazenados nas SharedPreferences
        SharedPreferences sharedPreferences = getSharedPreferences("UserPreferences", Context.MODE_PRIVATE);
        String email = sharedPreferences.getString("email", "Email não disponível");
        String nome = sharedPreferences.getString("nome", "Nome não disponível");
        String telefone = sharedPreferences.getString("telefone", "Telefone não disponível");
        String morada = sharedPreferences.getString("morada", "Morada não disponível");

        // Obter as referências dos TextViews
        TextView tvEmail = findViewById(R.id.textViewEmail);
        TextView tvNome = findViewById(R.id.textViewName);
        TextView tvTelefone = findViewById(R.id.textViewPhone);
        TextView tvMorada = findViewById(R.id.textViewAddress);

        // Atualizar os TextViews com os dados recuperados
        tvEmail.setText(email);
        tvNome.setText(nome);
        tvTelefone.setText(telefone);
        tvMorada.setText(morada);

        // Botão Alterar Dados
        Button buttonEditProfile = findViewById(R.id.buttonEditProfile);
        buttonEditProfile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Abrir a EditarDadosActivity
                Intent intent = new Intent(PerfilActivity.this, EditarDadosActivity.class);
                startActivity(intent);
            }
        });
    }
}
