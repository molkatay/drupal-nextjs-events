import Image from 'next/image'
import Link from 'next/link'
import React from 'react'
import {MenuFooter} from "./menu--footer";
import {absoluteUrl, loaderProp} from "../../lib/utils";

interface FooterProps {
    menus: {
        footer: any; // Replace with the correct type if known
    };
    siteInfos: {
        name: string;
        slogan: string;
        logo: string;
        favicon: string;
    };
}
 const FOOTER_CONTACT_INFO = {
    title: 'Contact Us',
    links: [
        { label: 'Admin Officer', value: '123-456-7890' },
        { label: 'Email Officer', value: 'hilink@akinthil.com' },
    ],
};

 const SOCIALS = {
    title: 'Social',
    links: [
        '/facebook.svg',
        '/instagram.svg',
        '/twitter.svg',
        '/youtube.svg',
        '/wordpress.svg',
    ],
};
const Footer: React.FC<FooterProps> = ({ menus, siteInfos, ...props }) => {
    return (
        <footer className="flexCenter mb-24">
            <div className="padding-container max-container flex w-full flex-col gap-14">
                <div className="flex flex-col items-start justify-center gap-[10%] md:flex-row">
                    <Link href="/" className="mb-10">
                        <Image src={absoluteUrl(siteInfos.logo)}  loader={loaderProp} alt={siteInfos.name} width={120} height={30}/>
                    </Link>

                    <div
                        className='flex flex-wrap gap-10 sm:justify-between md:flex-1'>

                        <div className="flex flex-col gap-5">
                            <FooterColumn title={FOOTER_CONTACT_INFO.title}>
                                {FOOTER_CONTACT_INFO.links.map((link) => (
                                    <Link
                                        href="/react/public"
                                        key={link.label}
                                        className="flex gap-4 md:flex-col lg:flex-row"
                                    >
                                        <p className="whitespace-nowrap">
                                            {link.label}:
                                        </p>
                                        <p className="medium-14 whitespace-nowrap text-blue-70">
                                            {link.value}
                                        </p>
                                    </Link>
                                ))}
                            </FooterColumn>
                        </div>

                        <div className="flex flex-col gap-5">
                            <FooterColumn title={SOCIALS.title}>
                                <ul className="regular-14 flex gap-4 text-gray-30">
                                    {SOCIALS.links.map((link) => (
                                        <Link href="/react/public" key={link}>
                                            <Image src={link} alt="logo"
                                                   width={24} height={24}/>
                                        </Link>
                                    ))}
                                </ul>
                            </FooterColumn>
                        </div>
                    </div>
                </div>

                <div className="border bg-gray-20"/>
                {menus && <MenuFooter menu={menus}/>}
                <p className="regular-14 w-full text-center text-gray-30">2023
                    {siteInfos.name} | All rights reserved</p>

            </div>
        </footer>
    )
}

type FooterColumnProps = {
    title: string;
    children: React.ReactNode;
}

const FooterColumn = ({title, children}: FooterColumnProps) => {
    return (
        <div className="flex flex-col gap-5">
            <h4 className="bold-18 whitespace-nowrap">{title}</h4>
            {children}
        </div>
    )
}

export default Footer
