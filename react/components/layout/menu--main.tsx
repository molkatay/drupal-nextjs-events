import { useRouter } from 'next/router';
import Link from 'next/link';
import classNames from 'classnames';
import { DrupalMenuLinkContent } from 'next-drupal';

interface MenuMainProps {
    menu?: DrupalMenuLinkContent[];
}

export function MenuMain({ menu, ...props }: MenuMainProps) {
    const router = useRouter();
    if (!menu?.length) {
        return null;
    }

    return (
        <ul className="hidden h-full gap-12 lg:flex" {...props}>
            {menu?.map((item) => {
                const isActive =
                    router.asPath === item.url ||
                    (item.url !== '/' ? router.asPath.indexOf(item.url) === 0 : false);

                return (
                    <li
                        key={item.id}
                        className={classNames('menu-item', {
                            'menu-item--active-trail': isActive,
                        })}
                    >
                        <Link
                            href={item.url}
                            className={classNames('regular-16 text-gray-50 flexCenter cursor-pointer pb-1.5 transition-all hover:font-bold')}
                        >
                            {item.title}
                        </Link>
                    </li>
                );
            })}
        </ul>
    );
}
