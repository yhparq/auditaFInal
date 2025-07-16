<template>
  <div class="min-h-screen bg-[#00367e] flex items-center justify-center px-4 py-8 bg-cover bg-center bg-no-repeat" style="background-image: url('/images/puno2.webp')">
    <div class="absolute inset-0 bg-[#00367e]/80"></div>
    
    <!-- Contenedor principal con dos columnas -->
    <div class="w-full max-w-6xl mx-auto flex items-center justify-between gap-12 z-10 relative">
      
      <!-- Columna izquierda: Logo y texto -->
      <div class="flex-1 text-center lg:text-left">
        <div class="mb-8 flex flex-col items-center lg:items-start">
          <!-- Título principal arriba -->
          <h1 class="text-5xl lg:text-6xl font-extrabold uppercase text-[#ffb300] mb-6 leading-tight text-center lg:text-left drop-shadow-lg">
            AULA VIRTUAL
          </h1>
          
          <!-- Logo centrado -->
          <img src="/images/logo1.png" alt="Logo Audita" class="h-40 lg:h-48 flex-shrink-0 mb-6" />
          
          <div class="w-32 h-1 bg-[#ffb300] mx-auto lg:mx-0 mb-6 relative">
            <div class="absolute left-0 top-0 w-1/2 h-1 bg-white"></div>
          </div>
          
          <!-- Información adicional -->
          <div class="text-blue-200 space-y-2 text-center lg:text-left">
            <p class="text-lg">✓ Acceso a cursos especializados</p>
            <p class="text-lg">✓ Certificación profesional</p>
            <p class="text-lg">✓ Sesiones en vivo con expertos</p>
            <p class="text-lg">✓ Material descargable</p>
          </div>
        </div>
      </div>

      <!-- Columna derecha: Formulario de login -->
      <div class="flex-1 max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
          <div class="text-center mb-6">
            <h3 class="text-2xl font-bold text-[#00367e]">Iniciar Sesión</h3>
            <p class="text-gray-600 mt-2">Accede con tu correo y DNI</p>
          </div>

          <form @submit.prevent="submit" class="space-y-6">
            <!-- Email Field -->
            <div>
              <label for="correo" class="block text-sm font-semibold text-[#00367e] mb-2">
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-2 text-[#00367e]" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                  </svg>
                  Correo Electrónico
                </span>
              </label>
              <div class="relative">
                <input
                  id="correo"
                  type="email"
                  v-model="form.correo"
                  class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00367e] focus:border-[#00367e] transition-colors duration-200 bg-white text-black placeholder-gray-400"
                  :class="{ 'border-red-500 bg-red-50': form.errors.correo }"
                  placeholder="participante@example.com"
                  required
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                  </svg>
                </div>
              </div>
              <div v-if="form.errors.correo" class="text-red-600 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ form.errors.correo }}
              </div>
            </div>

            <!-- DNI Field -->
            <div>
              <label for="dni" class="block text-sm font-semibold text-[#00367e] mb-2">
                <span class="flex items-center">
                  <svg class="w-4 h-4 mr-2 text-[#00367e]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-0.257-0.257A6 6 0 1118 8zM10 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                  </svg>
                  Contraseña
                </span>
              </label>
              <div class="relative">
                <input
                  id="dni"
                  type="password"
                  v-model="form.dni"
                  class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#00367e] focus:border-[#00367e] transition-colors duration-200 bg-white text-black placeholder-gray-400"
                  :class="{ 'border-red-500 bg-red-50': form.errors.dni }"
                  placeholder="12345678"
                  maxlength="8"
                  pattern="[0-9]{8}"
                  required
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0v2m0 0h4" />
                  </svg>
                </div>
              </div>
              <div v-if="form.errors.dni" class="text-red-600 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ form.errors.dni }}
              </div>
              <p class="text-xs text-gray-500 mt-1 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                Ingresa tu número de DNI de 8 dígitos
              </p>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <input
                  id="recordarme"
                  type="checkbox"
                  v-model="form.recordarme"
                  class="h-4 w-4 text-[#00367e] focus:ring-[#00367e] border-gray-300 rounded"
                >
                <label for="recordarme" class="ml-2 block text-sm text-gray-700">
                  Recordar sesión
                </label>
              </div>
            </div>

            <!-- Submit Button -->
            <button
              type="submit"
              :disabled="form.processing"
              class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-[#00367e] hover:bg-[#002a63] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00367e] transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
            >
              <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <svg v-if="form.processing" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg v-else class="h-5 w-5 text-white group-hover:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013 3v1" />
                </svg>
              </span>
              {{ form.processing ? 'Verificando credenciales...' : 'Ingresar al Aula Virtual' }}
            </button>
          </form>

          <!-- Info Section -->
          <div class="mt-6">
            <div class="relative">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Información</span>
              </div>
            </div>
            
            <div class="mt-4 bg-blue-50 border border-blue-200 rounded-xl p-4">
              <div class="space-y-2 text-xs text-blue-700">
                <div class="flex items-center">
                  <span class="w-16 font-medium">Usuario:</span>
                  <span>Tu correo registrado</span>
                </div>
                <div class="flex items-center">
                  <span class="w-16 font-medium">Contraseña:</span>
                  <span>Tu DNI (8 dígitos)</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Support -->
          <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
              ¿Problemas para acceder? 
              <a href="mailto:soporte@audita.com" class="text-[#00367e] hover:text-[#002a63] font-medium transition-colors duration-200">
                Soporte técnico
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="absolute bottom-4 left-0 right-0 text-center z-10">
      <p class="text-blue-200 text-sm">
        © 2025 AUDITA 2025
      </p>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

// Props para manejar errores del servidor
defineProps({
  errors: Object
})

// Crear formulario reactivo con Inertia
const form = useForm({
  correo: '',
  dni: '',
  recordarme: false
})

// Método para enviar el formulario
const submit = () => {
  form.post(route('aula-virtual.login.post'), {
    onFinish: () => {
      // Limpiar solo la contraseña en caso de error
      form.reset('dni')
    },
    onError: (errors) => {
      console.error('Errores de login:', errors)
    }
  })
}
</script>

<style scoped>
/* Responsividad mejorada */
@media (max-width: 1024px) {
  .max-w-6xl {
    flex-direction: column;
    gap: 2rem;
    padding: 1rem;
  }
  
  .flex-1:first-child {
    text-align: center;
  }
  
  .flex-1:first-child .flex-col.lg\\:flex-row {
    flex-direction: column;
    align-items: center;
  }
  
  .flex-1:first-child .w-32 {
    margin: 0 auto;
  }
}

@media (max-width: 768px) {
  .max-w-6xl {
    padding: 0.5rem;
  }
  
  .flex-1:last-child {
    max-width: 100%;
  }
  
  .bg-white.rounded-2xl {
    padding: 1.5rem;
    margin: 0 0.5rem;
  }
  
  .text-5xl.lg\\:text-6xl {
    font-size: 2.5rem;
  }
  
  .h-40.lg\\:h-48 {
    height: 8rem;
  }
}

@media (max-width: 640px) {
  .min-h-screen {
    padding: 1rem 0.5rem;
  }
  
  .space-y-6 {
    gap: 1rem;
  }
  
  .py-3.px-4 {
    padding: 0.75rem 1rem;
  }
}

/* Efectos de focus mejorados */
input:focus {
  box-shadow: 0 0 0 3px rgba(0, 54, 126, 0.1);
}

/* Efectos hover del botón */
button:hover:not(:disabled) {
  box-shadow: 0 10px 25px rgba(0, 54, 126, 0.3);
}

/* Asegurar que el texto en los inputs siempre sea negro y visible */
input[type="email"],
input[type="password"] {
  color: #000000 !important;
  background-color: #ffffff !important;
}

input[type="email"]:focus,
input[type="password"]:focus {
  color: #000000 !important;
  background-color: #ffffff !important;
}

/* Asegurar que el placeholder sea visible pero no interfiera */
input::placeholder {
  color: #9CA3AF !important;
  opacity: 0.7;
}
</style>