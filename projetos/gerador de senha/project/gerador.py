import random
import string
import tkinter as tk
from tkinter import messagebox

def solicitar_tamanho_senha():
    """Solicita ao usuário o tamanho da senha e valida a entrada."""
    while True:
        try:
            tamanho = int(input("Qual o tamanho da senha? (8 a 50 caracteres): "))
            if 8 <= tamanho <= 50:
                return tamanho
            else:
                print("Tamanho inválido. Tente novamente.")
        except ValueError:
            print("Entrada inválida. Por favor, insira um número.")

def gerar_senha(comprimento=25):
    """Gera uma senha aleatória com o comprimento especificado."""
    caracteres = string.ascii_letters + string.digits + string.punctuation
    senha = ''.join(random.choice(caracteres) for _ in range(comprimento))
    return senha

if __name__ == "__main__":
    tamanho = solicitar_tamanho_senha()
    senha = gerar_senha(tamanho)
    print(f"Senha gerada: {senha}")

janela = tk.Tk()
janela.title("Gerador de Senhas")
janela.geometry("400x200")

label_tamanho = tk.Label(janela, text="Tamanho da senha (8 a 50):")
label_tamanho.pack(pady=10)

entry_tamanho = tk.Entry(janela)
entry_tamanho.pack(pady=10)

botao_gerar = tk.Button(janela, text="Gerar Senha", command=lambda: gerar_senha(int(entry_tamanho.get())))
botao_gerar.pack(pady=10)

label_resultado = tk.Label(janela, text="Senha aparecerá aqui:")
label_resultado.pack(pady=10)

janela.mainloop()
