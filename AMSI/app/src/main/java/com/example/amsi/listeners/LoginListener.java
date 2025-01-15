package com.example.amsi.listeners;

import android.content.Context;

import com.example.amsi.modelo.Utilizador;

public interface LoginListener {
    void onValidateLogin(final Context context, final Utilizador utilizador);
}
