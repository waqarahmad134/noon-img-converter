import React from "react"
import { Link } from "react-router-dom"

export default function Header() {
  return (
    <>
      <header>
        <nav className="border-gray-200 py-2.5 flex justify-between cursor-pointer w-11/12 m-auto max-w-[1400px] mx-auto">
          <a to="/" className="flex items-center">
            <img src="/logo.png" className="mr-3 h-6 sm:h-9" alt="Logo" />
            <span className="self-center text-xl font-semibold whitespace-nowraptext-white">
              Noon Image Converter
            </span>
          </a>
        </nav>
      </header>
    </>
  )
}
