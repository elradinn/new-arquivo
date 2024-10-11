import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/Modules/Common/Types";
import { Box, Container, Paper, Stack, Text } from "@mantine/core";
import ApiTester from "./ApiTester";

export default function Dashboard() {
    return (
        <Authenticated>
            <Head title="Dashboard" />

            <Box py={48}>
                <Container size={1280} px={32}>
                    <Paper p={32} shadow="xs">
                        <ApiTester />
                    </Paper>
                </Container>
            </Box>
        </Authenticated>
    );
}
