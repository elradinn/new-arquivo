import React from "react";
import { Button, Flex, Modal, Stack, Text, TextInput } from "@mantine/core";
import { useUpdateUser } from "../Hooks/use-update-user";
import { UserResourceData } from "../Types/UserResourceData";

interface IProps {
    isOpened: boolean;
    close: () => void;
    user?: UserResourceData;
}

const UpdateUserForm: React.FC<IProps> = ({ isOpened, close, user }) => {
    const { data, setData, submit, processing, errors } = useUpdateUser({ user, close });

    return (
        <Modal opened={isOpened} onClose={close} title={<Text size="lg">Edit User</Text>} size={550}>
            <form onSubmit={submit}>
                <Stack gap={16}>
                    <TextInput
                        id="name"
                        type="text"
                        name="name"
                        value={data.name}
                        label="Name"
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                        required
                    />
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Save
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default UpdateUserForm;