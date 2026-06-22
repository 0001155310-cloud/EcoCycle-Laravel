import serial
import requests
import time
import json

# ================= CONFIGURAÇÕES =================
PORTA_SERIAL = 'COM7'  # Sua porta USB do Arduino
BAUD_RATE = 9600

# Ajustado exatamente para o servidor que está rodando no seu print
URL_API = "http://127.0.0.1/EcoCycle-Laravel/public/api/leituras" 
# =================================================

try:
    # Inicializa a conexão com o Arduino
    arduino = serial.Serial(PORTA_SERIAL, BAUD_RATE, timeout=1)
    print(f"Conectado com sucesso ao Arduino na porta {PORTA_SERIAL}!")
    print("Aguardando leituras... Mantenha esta janela aberta.")
    time.sleep(2) # Tempo para o Arduino reiniciar após conectar
except Exception as e:
    print(f"Erro ao conectar na porta {PORTA_SERIAL}: {e}")
    print("Verifique se o Monitor Serial da IDE do Arduino está fechado.")
    exit()

while True:
    try:
        # Se houver dados chegando na porta Serial
        if arduino.in_waiting > 0:
            # Lê a linha enviada pelo Arduino
            leitura = arduino.readline().decode('utf-8').strip()
            
            if leitura:
                # Converte o texto recebido (porcentagem) para número
                umidade = float(leitura)
                print(f"Sensor leu: {umidade}%")
                
                # Monta a estrutura JSON exatamente como o Laravel espera
                payload = {
                    "dispositivo_id": "estacao-uno",
                    "umidade": umidade,
                    "temperatura": 0, # Valores fixos fictícios já que o UNO só lê umidade por enquanto
                    "peso": 0,
                    "ph": 0,
                    "gas": 0
                }
                
                # Envia o POST para o Laravel
                headers = {'Content-Type': 'application/json'}
                resposta = requests.post(URL_API, data=json.dumps(payload), headers=headers)
                
                if resposta.status_code == 201:
                    print("-> Gravado no banco do Laragon com sucesso!")
                else:
                    print(f"-> Erro no Laravel (Status {resposta.status_code}): {resposta.text}")
                    
    except ValueError:
        # Ignora caso a linha venha incompleta ou com ruído
        pass
    except Exception as e:
        print(f"Ocorreu um erro: {e}")
        
    time.sleep(1) # Aguarda 1 segundo para o próximo ciclo
