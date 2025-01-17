package com.example.amsi;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.amsi.modelo.SingletonGestorProdutos;

public class SettingsActivity extends AppCompatActivity {

    private EditText etIpAddress;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_settings);

        etIpAddress = findViewById(R.id.etApiIp);
    }

    public void onClickAccept(View view) {
        String ipAddress = etIpAddress.getText().toString();
        Intent intent = new Intent(this, LoginActivity.class);

        SingletonGestorProdutos.getInstance(getApplicationContext()).setIpAddress(ipAddress, getApplicationContext());

        startActivity(intent);

    }
}