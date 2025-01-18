package com.example.amsi;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;
import android.widget.Button;


import androidx.appcompat.app.AppCompatActivity;

public class EditarDadosActivity extends AppCompatActivity {

    private EditText editTextEmail, editTextNome, editTextTelefone, editTextMorada;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_editar_dados);


        editTextEmail = findViewById(R.id.editTextEmail);
        editTextNome = findViewById(R.id.editTextNome);
        editTextTelefone = findViewById(R.id.editTextTelefone);
        editTextMorada = findViewById(R.id.editTextMorada);

        SharedPreferences sharedPreferences = getSharedPreferences("UserPreferences", Context.MODE_PRIVATE);
        editTextEmail.setText(sharedPreferences.getString("email", ""));
        editTextNome.setText(sharedPreferences.getString("nome", ""));
        editTextTelefone.setText(sharedPreferences.getString("telefone", ""));
        editTextMorada.setText(sharedPreferences.getString("morada", ""));

        // Botão Guardar
        findViewById(R.id.buttonSave).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                guardarDados();
            }
        });

        Button btnCancel = findViewById(R.id.btnCancel);
        btnCancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
    }

    private void guardarDados() {

        String email = editTextEmail.getText().toString();
        String nome = editTextNome.getText().toString();
        String telefone = editTextTelefone.getText().toString();
        String morada = editTextMorada.getText().toString();


        if (email.isEmpty() || nome.isEmpty() || telefone.isEmpty() || morada.isEmpty()) {
            Toast.makeText(this, "Por favor, preencha todos os campos!", Toast.LENGTH_SHORT).show();
            return;
        }


        SharedPreferences sharedPreferences = getSharedPreferences("UserPreferences", Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString("email", email);
        editor.putString("nome", nome);
        editor.putString("telefone", telefone);
        editor.putString("morada", morada);
        editor.apply();

        Toast.makeText(this, "Dados atualizados com sucesso!", Toast.LENGTH_SHORT).show();

        finish();
    }
}
