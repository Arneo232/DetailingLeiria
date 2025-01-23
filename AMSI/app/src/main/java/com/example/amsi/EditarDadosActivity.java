package com.example.amsi;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;
import android.widget.Button;

import androidx.appcompat.app.AppCompatActivity;

import com.example.amsi.modelo.SingletonGestorProdutos;
import com.example.amsi.modelo.UtilizadorBDHelper;
import com.example.amsi.modelo.Utilizador;

public class EditarDadosActivity extends AppCompatActivity {

    private EditText editTextEmail, editTextNome, editTextTelefone, editTextMorada;
    private UtilizadorBDHelper utilizadorBDHelper;
    private SharedPreferences sharedPreferences;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_editar_dados);

        // Inicializando as Views
        editTextEmail = findViewById(R.id.editTextEmail);
        editTextNome = findViewById(R.id.editTextNome);
        editTextTelefone = findViewById(R.id.editTextTelefone);
        editTextMorada = findViewById(R.id.editTextMorada);

        utilizadorBDHelper = new UtilizadorBDHelper(this);
        sharedPreferences = getSharedPreferences("UserPreferences", Context.MODE_PRIVATE);

        // Carregar os dados atuais do utilizador (com base nos dados do SharedPreferences)
        editTextEmail.setText(sharedPreferences.getString("email", ""));
        editTextNome.setText(sharedPreferences.getString("nome", ""));
        editTextTelefone.setText(sharedPreferences.getString("telefone", ""));
        editTextMorada.setText(sharedPreferences.getString("morada", ""));

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

        // Criar um objeto Utilizador com os dados atualizados
        Utilizador utilizadorAtualizado = new Utilizador();
        utilizadorAtualizado.setEmail(email);
        utilizadorAtualizado.setUsername(nome);  // Considerando que "nome" é o nome de utilizador
        utilizadorAtualizado.setNtelefone(telefone);
        utilizadorAtualizado.setMorada(morada);
        utilizadorAtualizado.setToken("");  // Se necessário, você pode definir um token ou mantê-lo

        int idUtilizador = sharedPreferences.getInt("id", -1);
        if (idUtilizador == -1) {
            Toast.makeText(this, "Erro: ID do utilizador não encontrado", Toast.LENGTH_SHORT).show();
            return;
        }
        Log.d("EditarDados", "ID recuperado: " + idUtilizador);

        // Definir o ID para o objeto Utilizador
        utilizadorAtualizado.setId(idUtilizador);

        // Atualizar na base de dados
        boolean sucesso = utilizadorBDHelper.editarUtilizadorBD(utilizadorAtualizado);

        if (sucesso) {
            SharedPreferences.Editor editor = sharedPreferences.edit();
            editor.putString("email", email);
            editor.putString("nome", nome);
            editor.putString("telefone", telefone);
            editor.putString("morada", morada);
            editor.commit();

            // Atualizar o utilizador no Singleton
            SingletonGestorProdutos.getInstance(this).setUtilizador(utilizadorAtualizado);

            // Mostrar mensagem de sucesso
            Toast.makeText(this, "Dados atualizados com sucesso!", Toast.LENGTH_SHORT).show();
            finish();
        } else {
            // Caso falhe a atualização na base de dados
            Toast.makeText(this, "Falha ao atualizar dados. Tente novamente.", Toast.LENGTH_SHORT).show();
        }
    }

}
