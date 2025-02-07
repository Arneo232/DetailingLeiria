package com.example.amsi;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import androidx.appcompat.widget.Toolbar;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import com.google.android.material.navigation.NavigationView;

public class MenuMainActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {

    private NavigationView navigationView;
    private DrawerLayout drawer;
    private String username = "Sem username";
    private FragmentManager fragmentManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu_main);

        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        drawer = findViewById(R.id.drawerLayout);
        navigationView = findViewById(R.id.navView);

        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(this, drawer, toolbar,
                R.string.ndOpen, R.string.ndClose);
        toggle.syncState();
        drawer.addDrawerListener(toggle);

        fragmentManager = getSupportFragmentManager();
        navigationView.setNavigationItemSelectedListener(this);

        carregarCabecalho();

        String startFragment = getIntent().getStringExtra("startFragment");
        if (startFragment != null && startFragment.equals("ListaProdutosFragment")) {
            Fragment fragment = new ListaProdutosFragment();
            fragmentManager.beginTransaction().replace(R.id.contentFragment, fragment).commit();
            setTitle("Produtos");
        }
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        Fragment fragment = null;

        if (item.getItemId() == R.id.navLoja) {
            fragment = new ListaProdutosFragment();
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.navPerfil) {
            Intent intent = new Intent(this, PerfilActivity.class);
            startActivity(intent);
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.navFavoritos) {
            fragment = new ListaFavoritosFragment();
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.navCarrinho) {
            fragment = new ListaCarrinhoFragment();
            setTitle(item.getTitle());
        }else if (item.getItemId() == R.id.navFaturas) {
            fragment = new ListaFaturasFragment();
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.navLogout) {
            logoutUser();
        }

        if (fragment != null) {
            fragmentManager.beginTransaction().replace(R.id.contentFragment, fragment).commit();
        }

        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

        private void carregarCabecalho() {
            username = getIntent().getStringExtra(LoginActivity.USERNAME);
            View hView = navigationView.getHeaderView(0);
            TextView tvUsername = hView.findViewById(R.id.tvUsername);
            tvUsername.setText(username);
        }

    private void logoutUser() {
        SharedPreferences sharedPreferences = getSharedPreferences("UserPreferences", Context.MODE_PRIVATE);

        Log.e("LogoutUser", "Before clearing: " + sharedPreferences.getAll().toString());

        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.clear();
        editor.apply();

        Log.e("LogoutUser", "After clearing: " + sharedPreferences.getAll().toString());

        Intent intent = new Intent(this, LoginActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
        finish();
    }
}
