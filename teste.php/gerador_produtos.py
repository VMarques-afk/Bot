import random
import xml.etree.ElementTree as ET

root = ET.Element("produtos")

tipos_motor = ["Monofásico", "Trifásico"]
carcaças = ["Alumínio", "Ferro Fundido"]
potencias = [f"{i}/{j} CV" for i in range(1, 11) for j in [2, 4, 8] if i <= j] + ["1 CV", "2 CV", "3 CV"]
tensoes = ["110V", "127V", "220V", "380V"]
aplicacoes = ["Compressores", "Bombas d'água", "Ventiladores", "Betoneiras", "Máquinas de corte", "Iluminação", "Quadros elétricos"]
valores = [random.uniform(10.00, 1000.00) for _ in range(1000)]

for i in range(1, 1001):
    produto = ET.SubElement(root, "produto", attrib={"id": str(i)})
    ET.SubElement(produto, "nome").text = f"Motor Elétrico {random.choice(tipos_motor)} {random.choice(potencias)} {random.choice(tensoes)}"
    ET.SubElement(produto, "descricao").text = f"Motor com carcaça de {random.choice(carcaças)}, proteção IP55, alta eficiência."
    ET.SubElement(produto, "aplicacao").text = random.choice(aplicacoes)
    ET.SubElement(produto, "valor").text = f"{valores[i-1]:.2f}"

tree = ET.ElementTree(root)
tree.write("lista_produtos_1000.xml", encoding="utf-8", xml_declaration=True)