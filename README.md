# DRACO

## IDEA DE PROYECTO

Se trata de una página web, plataforma donde puedes aprender sobre diferentes temáticas: The Lorf of the Rings, GloryHammer, War of Warcraft, Minecraft...

## ANÁLISIS DEL PROYECTO

La plataforma DRACO es una página web orientada al aprendizaje de diferentes universos de fantasía y videojuegos como The Lord of the Rings, GloryHammer, World of Warcraft y Minecraft. El proyecto surge como objeto de centralizar todo lo aprendido durante el 2º curso de DAW creando para el módulo de Proyecto Intermodular un entorno web accesible, organizado y fácil de usar.
El sistema va dirigido a usuarios interesados en el aprendizaje autodidacta y el entretenimiento educativo. Al ser una página web, se puede acceder desde cualquier dispositivo con navegador, sin necesidad de instalación.

### ESTRUCTURA DE CARPETAS

- Draco
  - todos los html aquí divididos en carpetas
  - css
    - todos los css generales aquí
    - css espec
      - todos los css específicos de una página en concreto aquí (puede que no sea necesaria esta carpeta)
      - css título minecraft
      - css grid glroyhammer
  - js
    - todos los js aquí
  - scss
    - todos los scss aquí
  - php
    - todos los php aquí
  - multimedia
    - audios
      - (todos los audios aquí divididos por tema)
      - minecraft
      - wow
      - gloryhammer
      - lord of the rings
      - ...

    - gifs/videos
      - (todos los gifs/vídeos aquí divididos por tema)
      - minecraft
      - wow
      - gloryhammer
      - lordofrings
      - ...

    - imágenes
      - todas las imágenes divididas por tema
      - minecraft
      - wow
      - gloryhammer
      - lordofrings
      - index
      - ...

## WEB INTERFACE DESIGN

### BRIEFING CUSTOMERS

**What is needed**

An educational website focused on learning and exploring fantasy and video game worlds, where the user can understand their history, characters, races, maps, world rules, and interesting facts in a clear, attractive, and organized way. The goal is not only to give information, but also to teach and spark curiosity.

**What type of interface is expected**

The client expects a visual and immersive interface with clear menus, sections by universe, and the use of images, videos, and audio.

**Who it is for**

It is for people interested in fantasy and video games, from beginners who want to understand a world before playing, to fans who want to test their knowledge.

**What limitations exist**

There are some limitations, such as the need to organize a large amount of information without overwhelming the user, and having a lot of information about each topic, which could lead to copyright issues.

### MOCK UP

https://design.penpot.app/#/view?file-id=115ba52a-c46a-8039-8007-70d10067839a&page-id=01ada482-695e-8018-8007-75c1a6445921&section=interactions&frame-id=01ada482-695e-8018-8007-75c210bc6613&index=0&share-id=65fc3905-adc4-807d-8007-75ca87ec765c

### WORKFLOW

1. The user accesses the home page (Index), where the DRACO platform and its educational purpose are presented.
2. From the main page, the user can:
   - Start learning right away without an account
   - Log in

3. If the user enters without an account, they must answer a series of questions and then start learning. They have 5 lives, and if they reach 0, they cannot learn anymore.
4. If the user wants to register, they must click on Log in and then on Register. If the user selects Register, they go to the registration screen where they enter their personal information.
   Once registered or after logging in, the user accesses their learning screen. If it is their first time, they must answer a series of questions to go to the learning page. 5. The user navigates through the available content (lessons, information, and educational material). 6. From the side menu, the user can access:
   - Profile
   - Progress
   - Settings

5. Finally, the user can log out from their profile.

### WIREFRAME

**Home Page (Index)**

The home page shows the DRACO logo, a short description of the project, and buttons to log in or sign up. Its purpose is to inform the user and make it easy to access the platform.

**Login**

This screen allows the user to log in using email and password. It includes a direct link to sign up if the user does not have an account.

**Sign Up**

The sign-up screen allows the user to create a new account by entering basic personal information. Once the registration is complete, the user can access the platform.

**Theme Selection**

This screen shows the different themes available on the DRACO platform. The user can choose the universe they want to learn using visual buttons.

**Learning Settings**

This screen allows the user to set up their learning experience, such as study pace and starting point within the chosen content.

**Content Platform**

It includes a side menu for navigation, a main content area, and links to sections like progress, profile, and settings. This is the main learning screen.

**User Profile**

Shows the user's information, their progress on the platform, and account settings options.

**Purchase Page**

The available purchase options are displayed on the page. A side menu is included for navigation.

### PUNTOS A MEJORAR

- "Modernizar la página web"
- Página "principal" con los 4 temas más jugados (GloryHammer / El Señor de los Anillos / WoW / Minecraft)
- Otra página como "directorio" de temas en formato cuadrícula con las portadas de todos los temas elegibles.
- Filtrar temas de los tests.
- Crear nuevos test (el usuario admin los puede crear)
- Crear usuarios (sin login, con login, administrador)
- Carrousel de imágenes para algunas fotos específicas de algún test

### COSAS A HACER POR APARTADOS

- USUARIOS
  - [ ] Formulario de creación de usuarios funcional y filtrado
  - [ ] Conexión a la base de datos para registro de nuevos usuarios
  - [ ] Comporbación del registro de los usuarios
  - [ ] Formulario de inicio de sesión funcional y filtrado
  - [ ] Conexión a la base de datos para comprobación de usuario y contraseña a la hora de iniciar sesión
  - [ ] Gestionar todos los datos de los usuarios en la base de datos para aclarar las funcionalidades de estos
  - [ ] Definir los distintos tipos de usuarios y las funciones que pueden realizar
