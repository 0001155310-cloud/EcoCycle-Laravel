import serial
import requests
import time
import json

# ================= CONFIGURAÇÃO =================
PORTA_SERIAL = 'COM7'  # Procure no Gerenciador de Dispositivos ou IDE do Arduino
URL_API = 'http://127.0.0.1/EcoCycle-Laravel/public/api/leituras'  # Ajuste para o endpoint correto da sua API
DISPOSITIVO_ID = 'arduino_01'
# ================================================

print(f"Buscando conexão na porta {PORTA_SERIAL}...")
try:
    arduino = serial.Serial(PORTA_SERIAL, 9600, timeout=1)
    time.sleep(2)  # Tempo para o Arduino reiniciar após conectar
    print("Conectado com sucesso ao Arduino!")
except Exception as e:
    print(f"Erro ao acessar {PORTA_SERIAL}: {e}")
    exit()

while True:
    try:
        if arduino.in_waiting > 0:
            # Lê a linha enviada pelo Arduino: "umidade,temperatura,gas"
            linha = arduino.readline().decode('utf-8').strip()
            
            # Pula linhas vazias ou de inicialização
            if not linha or "Iniciando" in linha:
                continue
                
            print(f"Dados brutos recebidos da Serial: {linha}")
            
            dados = linha.split(',')
            if len(dados) == 3:
                umidade_porcento = float(dados[0])
                temp_graus = float(dados[1])
                gas_ppm = float(dados[2])
                
                # Payload montado exatamente com os campos que o LeituraController valida
                payload = {
                    "dispositivo_id": DISPOSITIVO_ID,
                    "temperatura": temp_graus,
                    "umidade": umidade_porcento,
                    "gas": gas_ppm,
                    "ph": 7.0,          # Fornece um valor estável neutro por segurança
                    "peso": 0.0,        # Inicializa zerado já que o sensor de peso não foi mapeado
                    "origem_cliente": "painel_principal"
                }
                
                headers = {'Content-Type': 'application/json'}
                response = requests.post(URL_API, data=json.dumps(payload), headers=headers)
                
                print(f"-> Enviado para API! Resposta: {response.status_code} | {response.text}")
                
    except Exception as e:
        print(f"Falha ao processar dados: {e}")
        
    time.sleep(0.5)