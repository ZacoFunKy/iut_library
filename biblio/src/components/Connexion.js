import { Fragment } from "react";


function Connexion() {
  return (
    <Fragment>
      <div className="flex justify-center text-[#009999]">
        <form className="pt-6">
          <div className="mb-4 ">
            <h2 className="block  text-4xl font-bold mb-4 text-center">
              Connexion
            </h2>
            <input
              className="border-gray-300 placeholder-[#009999] appearance-none border rounded w-full py-2 px-3  leading-tight focus:outline-none focus:shadow-outline"
              id="username"
              type="text"
              placeholder="Nom"
            />
          </div>
          <div className="mb-6">
            <input
              className="border-gray-300 placeholder-[#009999] appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
              id="password"
              type="password"
              placeholder="Mot de passe"
            />
          </div>
          <div className="flex items-center justify-between">
            <button
              className="bg-[#009999] hover:bg-[#086969] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
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
