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
import android.widget.Toast;

import androidx.appcompat.widget.Toolbar;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import com.example.amsi.modelo.SingletonGestorProdutos;
import com.example.amsi.utils.ProdutoJsonParser;
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
            setTitle("Detailing Leiria");
        }
        if (getSupportActionBar() != null) {
            getSupportActionBar().setTitle("Detailing Leiria");
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
        } else if (item.getItemId() == R.id.navAbout) {
            Intent intent = new Intent(this, AboutUsActivity.class);
            startActivity(intent);
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.navFavoritos) {
            if (!ProdutoJsonParser.isConnectionInternet(this)) {
                Toast.makeText(this, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
                fragment = new ListaFavoritosFragment();
                setTitle(item.getTitle());
            }else{
                fragment = new ListaFavoritosFragment();
                setTitle(item.getTitle());
            }
        } else if (item.getItemId() == R.id.navCarrinho) {
            fragment = new ListaCarrinhoFragment();
            setTitle(item.getTitle());
        }else if (item.getItemId() == R.id.navFaturas) {
            fragment = new ListaFaturasFragment();
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.navContactos) {
            Intent intent = new Intent(this, ContactActivity.class);
            startActivity(intent);
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.navLogout) {
            SingletonGestorProdutos singletonGestorProdutos = SingletonGestorProdutos.getInstance(this);
            singletonGestorProdutos.logoutAPI(this);
            Intent intent = new Intent(this, LoginActivity.class);
            startActivity(intent);
            finish();
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
}
