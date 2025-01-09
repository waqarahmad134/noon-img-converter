import React from "react"
import { Link } from "react-router-dom"

export default function Header() {
  return (
    <>
      <header>
        <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 flex justify-between">
          <div class="">
            <a to="/" class="flex items-center">
              <img
                src="https://flowbite.com/docs/images/logo.svg"
                class="mr-3 h-6 sm:h-9"
                alt="Logo"
              />
              <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">
                Noon Image Converter
              </span>
            </a>
          </div>
          <div class="flex justify-end items-center w-full ">
            <ul class="flex mt-4 font-medium lg:mt-0 gap-4">
              {/* <li>
                <Link
                  to={"/"}
                  class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700"
                >
                  Whastapp Format
                </Link>
              </li>
              <li>
                <Link
                  to="/google"
                  class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700"
                >
                  Google Format
                </Link>
              </li> */}
            </ul>
          </div>
        </nav>
      </header>
    </>
  )
}
