import serial
import requests
import time
import re

# Configurações - Altere a porta COM se necessário
PORTA_SERIAL = 'COM3'  # No Windows costuma ser COM3, COM4, etc.
BAUD_RATE = 9600
# Caminho relativo ou absoluto da API do seu sistema no Render
URL_API = 'https://ecocycle-us8p.onrender.com/api/sensor/dados' 

print("Iniciando ponte de comunicação com o Render...")

while True:
    try:
        # Tenta conectar à porta USB do Arduino
        ser = serial.Serial(PORTA_SERIAL, BAUD_RATE, timeout=1)
        print(f"Conectado com sucesso na porta {PORTA_SERIAL}")
        
        while True:
            if ser.in_waiting > 0:
                # Lê a linha enviada pelo Arduino
                linha = ser.readline().decode('utf-8', errors='ignore').strip()
                
                # Expressão regular para capturar os números printados pelo Arduino
                match = re.search(r"Temp:\s*([\d\.]+)\s*\|\s*Umidade:\s*(\d+)\s*\|\s*Gas:\s*(\d+)", linha)
                
                if match:
                    temp = float(match.group(1))
                    umidade = int(match.group(2))
                    gas = int(match.group(3))
                    
                    # Monta o JSON esperado pelo seu Laravel
                    dados = {
                        "temperatura": temp,
                        "umidade": umidade,
                        "gas": gas
                    }
                    
                    # Envia para a nuvem
                    try:
                        resposta = requests.post(URL_API, json=dados, timeout=5)
                        if resposta.status_code == 200 or resposta.status_code == 201:
                            print(f"Dados enviados para o Render: {dados}")
                        else:
                            print(f"Erro na API ({resposta.status_code}): {resposta.text}")
                    except requests.exceptions.RequestException:
                        print("Erro de conexão ao tentar alcançar o servidor Render.")
                        
            time.sleep(1)
            
    except serial.SerialException:
        print(f"Aguardando o Arduino ser conectado na porta {PORTA_SERIAL}...")
        time.sleep(5) # Tenta reconectar a cada 5 segundos se o cabo for desplugado