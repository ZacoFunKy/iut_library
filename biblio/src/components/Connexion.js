import { Fragment } from "react";
import Header from "./Header";


function Connexion() {
  return (
    <Fragment>
      <div class="flex justify-center text-[#009999] mt-8 p-8">
        <form class="pt-6">
          <div class="mb-4 ">
            <label
              class="block  text-4xl font-bold mb-9 text-center"
              for="username"
            >
              Connexion
            </label>
            <input
              class="border-gray-300 placeholder-[#009999] appearance-none border rounded w-full py-2 px-3  leading-tight focus:outline-none focus:shadow-outline"
              id="username"
              type="text"
              placeholder="Nom"
            />
          </div>
          <div class="mb-6">
            <input
              class="border-gray-300 placeholder-[#009999] appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
              id="password"
              type="password"
              placeholder="Mot de passe"
            />
          </div>
          <div class="flex items-center justify-between">
            <button
              class="bg-[#009999] hover:bg-[#086969] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              type="button"
            >
              Se connecter
            </button>
          </div>
        </form>
      </div>
    </Fragment>
  );
}

export default Connexion;
