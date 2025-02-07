package com.example.amsi.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.RatingBar;
import android.widget.TextView;
import android.widget.Toast;
import androidx.appcompat.app.AlertDialog;
import com.example.amsi.R;
import com.example.amsi.modelo.Avaliacao;
import com.example.amsi.modelo.SingletonGestorProdutos;
import java.util.ArrayList;

public class ListaAvaliacoesAdaptador extends BaseAdapter {
    private Context context;
    private ArrayList<Avaliacao> avaliacoes;
    private LayoutInflater inflater;

    public ListaAvaliacoesAdaptador(Context context, ArrayList<Avaliacao> avaliacoes) {
        this.context = context;
        this.avaliacoes = avaliacoes;
        this.inflater = LayoutInflater.from(context);
    }

    @Override
    public int getCount() {
        return avaliacoes.size();
    }

    @Override
    public Object getItem(int position) {
        return avaliacoes.get(position);
    }

    @Override
    public long getItemId(int position) {
        return avaliacoes.get(position).getIdavaliacao();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        ViewHolder viewHolder;

        if (convertView == null) {
            convertView = inflater.inflate(R.layout.item_avaliacao, parent, false);
            viewHolder = new ViewHolder(convertView);
            convertView.setTag(viewHolder);
        } else {
            viewHolder = (ViewHolder) convertView.getTag();
        }

        viewHolder.update(avaliacoes.get(position), position);

        return convertView;
    }

    private class ViewHolder {
        private TextView tvUtilizador, tvComentario;
        private RatingBar rbAvaliacao;
        private ImageButton btnDeleteAvaliacao;

        public ViewHolder(View view) {
            tvUtilizador = view.findViewById(R.id.tvUtilizador);
            tvComentario = view.findViewById(R.id.tvComentario);
            rbAvaliacao = view.findViewById(R.id.rbAvaliacao);
            btnDeleteAvaliacao = view.findViewById(R.id.btnDeleteAvaliacao);
        }

        public void update(Avaliacao avaliacao, int position) {
            tvUtilizador.setText(avaliacao.getNomeutilizador());
            tvComentario.setText(avaliacao.getComentario());
            rbAvaliacao.setRating((float) avaliacao.getRating());

            if (avaliacao.getIdProfileFK() == SingletonGestorProdutos.getInstance(context).utilizador.getIdprofile()) {
                btnDeleteAvaliacao.setVisibility(View.VISIBLE);
                btnDeleteAvaliacao.setOnClickListener(v -> showDeleteDialog(avaliacao, position));
            } else {
                btnDeleteAvaliacao.setVisibility(View.GONE);
            }
        }

        private void showDeleteDialog(Avaliacao avaliacao, int position) {
            new AlertDialog.Builder(context)
                    .setTitle("Remover Avaliação")
                    .setMessage("Tem certeza que deseja remover este comentário?")
                    .setPositiveButton("Sim", (dialog, which) -> {
                        SingletonGestorProdutos.getInstance(context).removerAvaliacaoAPI(
                                context,
                                avaliacao.getIdavaliacao(),
                                response -> {
                                    avaliacoes.remove(position);
                                    notifyDataSetChanged();
                                    Toast.makeText(context, "Comentário removido.", Toast.LENGTH_SHORT).show();
                                }
                        );
                    })
                    .setNegativeButton("Não", null)
                    .show();
        }
    }
}
