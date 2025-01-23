package com.example.amsi;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import com.example.amsi.modelo.Utilizador;
import com.example.amsi.modelo.SingletonGestorProdutos;

public class PerfilActivity extends AppCompatActivity {

    private SharedPreferences sharedPreferences;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_perfil);

        // Obter o utilizador mais recente do Singleton
        Utilizador utilizador = SingletonGestorProdutos.getInstance(this).getUtilizador();

        if (utilizador != null) {
            // Atualizar os TextViews com os dados do utilizador
            TextView tvEmail = findViewById(R.id.textViewEmail);
            TextView tvNome = findViewById(R.id.textViewName);
            TextView tvTelefone = findViewById(R.id.textViewPhone);
            TextView tvMorada = findViewById(R.id.textViewAddress);

            // Inicializando o SharedPreferences
            sharedPreferences = getSharedPreferences("UserPreferences", Context.MODE_PRIVATE);

            // Carregar os dados atuais do utilizador (com base nos dados do SharedPreferences)
            tvEmail.setText(sharedPreferences.getString("email", ""));
            tvNome.setText(sharedPreferences.getString("nome", ""));
            tvTelefone.setText(sharedPreferences.getString("telefone", ""));
            tvMorada.setText(sharedPreferences.getString("morada", ""));
        } else {
            // Caso não exista um utilizador no Singleton
            Toast.makeText(this, "Não foi possível carregar os dados do utilizador", Toast.LENGTH_SHORT).show();
        }

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

