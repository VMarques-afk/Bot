import random
import xml.etree.ElementTree as ET

root = ET.Element("produtos")

tipos_produto = ["Alternador", "Amortecedor", "Bomba de Combustível", "Disco de Freio", "Pastilha de Freio", "Correia Dentada", "Bateria", "Polia", "Termostato", "Kit de Embreagem"]
aplicacoes = ["Sistemas elétricos", "Suspensão", "Sistema de alimentação", "Frenagem", "Motor", "Partida", "Transmissão"]
valores = [random.uniform(50.00, 600.00) for _ in range(1000)]
tensoes = ["12V", "24V"]  # Para itens elétricos

for i in range(1, 1001):
    produto = ET.SubElement(root, "produto", attrib={"id": str(i)})
    nome = f"{random.choice(tipos_produto)} {random.choice(tensoes) if random.choice(tipos_produto) in ['Alternador', 'Bateria'] else ''}"
    ET.SubElement(produto, "nome").text = nome
    ET.SubElement(produto, "descricao").text = f"Peça de alta qualidade para {random.choice(aplicacoes)}, durabilidade garantida."
    ET.SubElement(produto, "aplicacao").text = random.choice(aplicacoes)
    ET.SubElement(produto, "valor").text = f"{valores[i-1]:.2f}"

tree = ET.ElementTree(root)
tree.write("lista_produtos_1000.xml", encoding="utf-8", xml_declaration=True)




