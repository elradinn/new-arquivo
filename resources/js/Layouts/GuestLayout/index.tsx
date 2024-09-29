import { PropsWithChildren } from "react";
import ApplicationLogo from "@/Components/ApplicationLogo";
import { Link } from "@inertiajs/react";
import { Flex, Paper } from "@mantine/core";
import classes from "./GuestLayout.module.css";

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
                    <ApplicationLogo
                        height={80}
                        width={80}
                        className={classes.logo}
                    />
                </Link>
            </div>

            <Paper shadow="md" radius="md" className={classes.card}>
                {children}
            </Paper>
        </Flex>
    );
}
