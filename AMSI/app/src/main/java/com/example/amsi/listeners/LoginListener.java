package com.example.amsi.listeners;

import android.content.Context;

import com.example.amsi.modelo.Utilizador;

public interface LoginListener {
    void onValidateLogin(final Context context, final String auth_key, final String username, final String email, final int profileId);
}
