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
import com.example.amsi.listeners.UtilizadorListener;

public class PerfilActivity extends AppCompatActivity implements UtilizadorListener {
    private TextView tvEmail, tvNome, tvTelefone, tvMorada;
    private Button buttonEditProfile;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_perfil);

        tvEmail = findViewById(R.id.textViewEmail);
        tvNome = findViewById(R.id.textViewName);
        tvTelefone = findViewById(R.id.textViewPhone);
        tvMorada = findViewById(R.id.textViewAddress);
        buttonEditProfile = findViewById(R.id.buttonEditProfile);

        SingletonGestorProdutos.getInstance(this).setUtilizadorListener(this);
        SingletonGestorProdutos.getInstance(this).getUtilizadorAPI(this);

        buttonEditProfile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(PerfilActivity.this, EditarDadosActivity.class);
                startActivity(intent);
            }
        });
    }

    @Override
    protected void onResume() {
        super.onResume();

        SharedPreferences sharedPreferences = getSharedPreferences("UsePreferences", Context.MODE_PRIVATE);
        String novoEmail = sharedPreferences.getString("email", "");
        String novoNome = sharedPreferences.getString("nome", "");
        String novoTelefone = sharedPreferences.getString("telefone", "");
        String novaMorada = sharedPreferences.getString("morada", "");

        tvEmail.setText(novoEmail);
        tvNome.setText(novoNome);
        tvTelefone.setText(novoTelefone);
        tvMorada.setText(novaMorada);
    }

    @Override
    public void onRefreshUtilizador(Utilizador utilizador) {
        if (utilizador != null) {
            tvEmail.setText(utilizador.getEmail());
            tvNome.setText(utilizador.getUsername());
            tvTelefone.setText(utilizador.getNtelefone());
            tvMorada.setText(utilizador.getMorada());
        } else {
            Toast.makeText(this, "Não foi possível carregar os dados do utilizador", Toast.LENGTH_SHORT).show();
        }
    }
}
