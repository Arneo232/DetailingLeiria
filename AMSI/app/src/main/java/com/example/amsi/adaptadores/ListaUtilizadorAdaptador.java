package com.example.amsi.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.example.amsi.R;
import com.example.amsi.modelo.Utilizador;

import java.util.List;

public class ListaUtilizadorAdaptador extends BaseAdapter {

    private Context context;
    private List<Utilizador> utilizadorList;

    public ListaUtilizadorAdaptador(Context context, List<Utilizador> utilizadorList) {
        this.context = context;
        this.utilizadorList = utilizadorList;
    }

    @Override
    public int getCount() {
        return utilizadorList.size();
    }

    @Override
    public Object getItem(int position) {
        return utilizadorList.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (convertView == null) {
            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            convertView = inflater.inflate(R.layout.activity_perfil, parent, false);
        }

        Utilizador utilizador = utilizadorList.get(position);

        TextView tvEmail = convertView.findViewById(R.id.textViewEmail);
        TextView tvNome = convertView.findViewById(R.id.textViewName);
        TextView tvTelefone = convertView.findViewById(R.id.textViewPhone);
        TextView tvMorada = convertView.findViewById(R.id.textViewAddress);

        tvEmail.setText(utilizador.getEmail());
        tvNome.setText(utilizador.getUsername());
        tvTelefone.setText(utilizador.getNtelefone());
        tvMorada.setText(utilizador.getMorada());

        return convertView;
    }
}