package com.example.amsi;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;
import android.widget.Button;

import androidx.appcompat.app.AppCompatActivity;

import com.example.amsi.modelo.SingletonGestorProdutos;

public class EditarDadosActivity extends AppCompatActivity {

    private EditText editTextEmail, editTextNome, editTextTelefone, editTextMorada;
    private Button buttonSave, btnCancelar;

    private SharedPreferences sharedPreferences;
    private SharedPreferences.Editor editar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_editar_dados);
        setTitle("Editar dados");

        editTextEmail = findViewById(R.id.editTextEmail);
        editTextNome = findViewById(R.id.editTextNome);
        editTextTelefone = findViewById(R.id.editTextTelefone);
        editTextMorada = findViewById(R.id.editTextMorada);
        buttonSave = findViewById(R.id.buttonSave);
        btnCancelar = findViewById(R.id.btnCancelar);

        sharedPreferences = getSharedPreferences("UserPreferences", Context.MODE_PRIVATE);
        editar = sharedPreferences.edit();

        String currentEmail = sharedPreferences.getString("email", "");
        String currentNome = sharedPreferences.getString("nome", "");
        String currentTelefone = sharedPreferences.getString("telefone", "");
        String currentMorada = sharedPreferences.getString("morada", "");

        editTextEmail.setText(currentEmail);
        editTextNome.setText(currentNome);
        editTextTelefone.setText(currentTelefone);
        editTextMorada.setText(currentMorada);

        buttonSave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String novoEmail = editTextEmail.getText().toString().trim();
                String novoNome = editTextNome.getText().toString().trim();
                String novoTelefone = editTextTelefone.getText().toString().trim();
                String novaMorada = editTextMorada.getText().toString().trim();

                if (!novoEmail.isEmpty() && !novoNome.isEmpty() && !novoTelefone.isEmpty() && !novaMorada.isEmpty()) {
                    SingletonGestorProdutos.getInstance(EditarDadosActivity.this)
                            .atualizarPerfilAPI(EditarDadosActivity.this, novoNome, novoEmail, novaMorada, novoTelefone);

                    editar.putString("email", novoEmail);
                    editar.putString("nome", novoNome);
                    editar.putString("telefone", novoTelefone);
                    editar.putString("morada", novaMorada);
                    editar.apply();

                    Toast.makeText(EditarDadosActivity.this, "Dados atualizados com sucesso!", Toast.LENGTH_SHORT).show();
                    Intent intent = new Intent(EditarDadosActivity.this, PerfilActivity.class);
                    intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    startActivity(intent);
                    finish();
                } else {
                    Toast.makeText(EditarDadosActivity.this, "Todos os campos são obrigatórios!", Toast.LENGTH_SHORT).show();
                }
            }
        });

        btnCancelar.setOnClickListener(new View.OnClickListener(){
           @Override
           public void onClick(View v){
               Intent cancelar = new Intent(EditarDadosActivity.this, PerfilActivity.class);
               startActivity(cancelar);
           }
        });
    }
}
