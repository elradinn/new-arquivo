import { PropsWithChildren } from "react";
import { Link } from "@inertiajs/react";
import { Flex, Paper } from "@mantine/core";
import classes from "./GuestLayout.module.css";
import OfficeLogo from "@/Modules/Common/Components/OfficeLogo/OfficeLogo";

export default function Guest({ children }: PropsWithChildren) {
    return (
        <Flex
            direction="column"
            align="center"
            mih="100vh"
            justify="center"
            pt={24}
            style={{
                backgroundColor:
                    "light-dark(var(--mantine-color-gray-0), var(--mantine-color-dark-6))",
            }}
        >
            <div>
                <Link href="/">
                    <OfficeLogo h={96} w={96} />
                </Link>
            </div>

            <Paper shadow="md" radius="md" className={classes.card}>
                {children}
            </Paper>
        </Flex>
    );
}
